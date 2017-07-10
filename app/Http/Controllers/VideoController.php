<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use App\Helpers\Meta;
use App\User;
use App\Video;
use File;
use Carbon;
use Zipper;
use Auth;
use Session;
use Redirect;
use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_VideoSnippet;
use Google_Service_YouTube_VideoStatus;
use Google_Service_YouTube_Video;
use Google_Http_MediaFileUpload;

class VideoController extends Controller
{
    public function video($gusermail) {
        if(Auth::check() &&  Auth::user()->g_username == $gusermail ) {
        	$provider_id = User::Select('provider_id')
        							->Where('g_username', $gusermail)
        							->first()->toArray();
			$videos = Video::Select('*')
									->Where('provider_id', $provider_id['provider_id'])
									->get();
            return view('video_view')
            		->with('videos', $videos)
            		->with('meta',Meta::get());
        }
        else {
            return redirect(route('gusermail', ['gusermail' => $gusermail]));
        }
    }

    public function uploadVideo(Request $request) {

        $video = Input::file('video');

        if($video) {
        	$time = Carbon\Carbon::now();
            $gusermail = Auth::user()->g_username;
            $extension = $video->extension();
            // dd($extension);
            $orgFilename = $video->getClientOriginalName();
            $title = pathinfo($orgFilename, PATHINFO_FILENAME);
            $filename = $title."_".time()."_".$gusermail.'.'.$extension;

            // $extension = pathinfo($fullfilename, PATHINFO_EXTENSION);
            
            $video->move(public_path().'/videos', $filename);
            
	        $client = new Google_Client();
			$client->setAuthConfigFile(__DIR__ . '/video.json');
			$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback');
			$client->setScopes('https://www.googleapis.com/auth/youtube');
			$client->setAccessType('offline');
			$refreshToken = env('YOUTUBE_REFRESH_TOKEN');
			$client->fetchAccessTokenWithRefreshToken($refreshToken);
			$client->getAccessToken();
			
			/*Reference URL : https://developers.google.com/youtube/v3/docs/videos/insert */

			$youtube = new Google_Service_YouTube($client);
			
			$videoPath = public_path().'/videos/'.$filename;

		    $snippet = new Google_Service_YouTube_VideoSnippet();
		    $snippet->setTitle($title);
		    $snippet->setDescription("Test description");
		    $snippet->setTags(array("tag1", "tag2"));

		    $snippet->setCategoryId("22");

		    $status = new Google_Service_YouTube_VideoStatus();
		    $status->privacyStatus = "public";

		    $video = new Google_Service_YouTube_Video();
		    $video->setSnippet($snippet);
		    $video->setStatus($status);

		    $chunkSizeBytes = 1 * 1024 * 1024;

		    $client->setDefer(true);

		    $insertRequest = $youtube->videos->insert("status,snippet", $video);

		    $media = new Google_Http_MediaFileUpload(
		        $client,
		        $insertRequest,
		        'video/*',
		        null,
		        true,
		        $chunkSizeBytes
		    );
		    $media->setFileSize(filesize($videoPath));

		    $status = false;
		    $handle = fopen($videoPath, "rb");
		    while (!$status && !feof($handle)) {
		      $chunk = fread($handle, $chunkSizeBytes);
		      $status = $media->nextChunk($chunk);
		    }

		    fclose($handle);

		    $client->setDefer(false);

		    $provider_id = User::Select('provider_id')->Where('g_username', $gusermail)->first()->toArray();
            $video_id = sha1($provider_id['provider_id'].$filename.$time);

            $video_data = new Video();
            $video_data->provider_id = $provider_id['provider_id'];
            $video_data->video_id = $video_id;
            $video_data->video_name = $filename;
            $video_data->youtube_id = $status['id'];
            $video_data->save();

            $video_data = Video::Select('video_id', 'video_name')->Where('id',$video_data->id)->get();

		    return response()->json($video_data);
		    // dd($status['id']);
		}

    }

    public function deleteVideo(Request $request, $video_id)
    {
        $video_name = Video::Select('video_name')->Where('video_id', $video_id)->first();
        File::delete(public_path().'/videos/'.$video_name['video_name']);
        Video::Where('video_id', $video_id)->delete();

        // $client = new Google_Client();
        // $client->setAuthConfigFile(__DIR__ . '/video.json');
        // $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback');
        // $client->setScopes('https://www.googleapis.com/auth/youtube');
        // $client->setAccessType('offline');
        // $refreshToken = env('YOUTUBE_REFRESH_TOKEN');
        // $client->fetchAccessTokenWithRefreshToken($refreshToken);
        // $client->getAccessToken();
        // $youtube = new Google_Service_YouTube($client);
        // $youtube->videos->delete($video_id);

        return response()->json($video_id);
    }

}
