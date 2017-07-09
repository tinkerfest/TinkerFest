<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use App\Helpers\Meta;
use App\User;
use App\Document;
use File;
use Carbon;
use Zipper;
use Auth;
use Session;
use Redirect;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

define('APPLICATION_NAME', 'TinkerFest');
define('CLIENT_SECRET_PATH', __DIR__ . '/drive.json');
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE_METADATA_READONLY)
));

class DocumentController extends Controller
{
    public function documents($gusermail) {
        if(Auth::check() &&  Auth::user()->g_username == $gusermail ) {
        	$provider_id = User::Select('provider_id')
        							->Where('g_username', $gusermail)
        							->first()->toArray();
			$documents = Document::Select('*')
									->Where('provider_id', $provider_id['provider_id'])
									->get();
            return view('documents')
            		->with('documents', $documents)
            		->with('meta',Meta::get());
        }
        else {
            return redirect(route('gusermail', ['gusermail' => $gusermail]));
        }
    }

    public function documentDownload($gusermail, $document_id) {
        
            $provider_id = User::Select('provider_id')
                                    ->Where('g_username', $gusermail)
                                    ->first()->toArray();
            $document = Document::Select('*')
                                            ->Where('provider_id', $provider_id['provider_id'])
                                            ->Where('document_id', $document_id)
                                            ->first()->toArray();
            $headers = array(
                'Content-Type' => 'application/octet-stream',
            );

            $public_dir = public_path();
            $fileName = $document['document_name'];
            $filetopath= $public_dir.'/documents/'.$fileName;

            if(file_exists($filetopath)){
                return response()->download($filetopath,$fileName,$headers);
            }   
    }

    public function documentView($gusermail, $googledrive_id) {
        	$provider_id = User::Select('provider_id')
        							->Where('g_username', $gusermail)
        							->first()->toArray();
			$document = Document::Select('*')
											->Where('provider_id', $provider_id['provider_id'])
											->Where('googledrive_id', $googledrive_id)
											->first()->toArray();
            return view('document_view')
            		->with('document', $document)
            		->with('meta',Meta::get());	
    }

    public function getClient() {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $authUrl = $client->createAuthUrl();
        //$accessToken = env('GOOGLE_DRIVE_ACCESS_TOKEN');
        $refreshToken = env('GOOGLE_DRIVE_REFRESH_TOKEN');
        //$client->setAccessToken($accessToken);
        $client->fetchAccessTokenWithRefreshToken($refreshToken);
        $client->getAccessToken();
        return $client;
    }

    public function uploadDocuments(Request $request) {
        
        $result = new Collection();

        $files = Input::file('documents');
        
        if ($files) {

            foreach($files as $key => $value) {
                $time = Carbon\Carbon::now();
                $gusermail = Auth::user()->g_username;
                $extension = $files[$key]->extension();
                // dd($extension);
                $orgFilename = $files[$key]->getClientOriginalName();
                $title = pathinfo($orgFilename, PATHINFO_FILENAME);
                $filename = $title."_".time()."_".$gusermail.'.'.$extension;

                // $extension = pathinfo($fullfilename, PATHINFO_EXTENSION);
                
                $files[$key]->move(public_path().'/documents', $filename);
                    
                $content = file_get_contents(public_path().'/documents/'.$filename);


                if(	$extension == "pptx" || $extension == "ppt" || $extension == "odp" ) {

                    $client = $this->getClient();
                    $service = new Google_Service_Drive($client);

                    /* Create folder in Drive */

                    // $fileMetadata = new Google_Service_Drive_DriveFile(array(
                    //                     'name' => 'Invoices',
                    //                     'mimeType' => 'application/vnd.google-apps.folder'));
                    // $folder = $service->files->create($fileMetadata, array(
                    //                     'fields' => 'id'));
                    // printf("Folder ID: %s\n", $folder->id);
                    // exit();

                    /* Create folder in Drive */

                    $folderId = env('GOOGLE_DRIVE_FOLDER_ID');
         			
    	 			$fileMetadata = new Google_Service_Drive_DriveFile(array(
    	              'name' => $filename,
    	              'mimeType' => 'application/vnd.google-apps.presentation',
    	              'parents' => array($folderId)
    	            ));
                    
                    // dd($fileMetadata);
                    $googledrive = $service->files->create($fileMetadata, array(
                      'data' => $content,
                      'uploadType' => 'multipart',
                      'fields' => 'id')
                    );
                    //dd($googledrive);

                    $googledrive_id = $googledrive->id;

        			$googledrive_url = 'https://docs.google.com/presentation/d/'.$googledrive_id.'/embed?start=false&loop=false&delayms=3000';

                    // $thumbnail_url = 'https://lh3.google.com/u/0/d/'.$googledrive_id.'=w200-h150-p-k-nu-iv1';
                }
                else {
                    $googledrive_id = "";
                    $googledrive_url = "";
                }

                $provider_id = User::Select('provider_id')->Where('g_username', $gusermail)->first()->toArray();
                $document_id = sha1($provider_id['provider_id'].$filename.$time);

                $document_data[$key] = new Document();
                $document_data[$key]->provider_id = $provider_id['provider_id'];
                // $document_data[$key]->p_id = ;
                $document_data[$key]->document_id = $document_id;
                $document_data[$key]->document_name = $filename;
                $document_data[$key]->googledrive_id = $googledrive_id;
                $document_data[$key]->googledrive_url = $googledrive_url;
                $document_data[$key]->thumbnail_url = $extension;
                $document_data[$key]->save();

                $document_data[$key] = Document::Select('document_id', 'document_name')->Where('id',$document_data[$key]->id)->get();
                $result = $result->merge($document_data[$key]); 
            }
            return response()->json($result);
        }
        else {
            return "404 not Found";
        }
    }

    public function deleteDocuments(Request $request, $document_id)
    {
        $document_name = Document::Select('document_name')->Where('document_id', $document_id)->first();
        File::delete(public_path().'/documents/'.$document_name['document_name']);
        Document::Where('document_id', $document_id)->delete();
        return response()->json($document_id);
    }

    public function download() {

        if(Auth::check() && in_array( Auth::user()->g_username, ['devangbhuva123','mailtojimish','dhruvsaidava'])) {
            $public_dir = public_path();
            $zipFileName = '_p_content.zip';
            $filetopath= $public_dir.'/presentation/'.$zipFileName;

            $files = glob($public_dir.'/_p_content/*');
            Zipper::make($filetopath)->add($files)->close();

            $headers = array(
                    'Content-Type' => 'application/octet-stream',
                );

            if(file_exists($filetopath)){
                return response()->download($filetopath,$zipFileName,$headers);
            }
            return ['status'=>'file does not exist'];
        }
        else {
            return "404 not Found";
        }

        // File::delete($filetopath);   
    }
}
