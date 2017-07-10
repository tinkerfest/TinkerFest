<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\CategoryMap;
use App\Document;
use App\Video;
use Auth;
use Uuid;

class PostController extends Controller
{
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function create(Request $r)
    {
        try {
            $input['p_id']        = Uuid::generate(5, Auth::user()->g_username . $r->p_title, Uuid::NS_DNS);

            $pc = public_path().'/_p_content/'.$this->generateRandomString(30);
            file_put_contents($pc, $r->p_content);
            date_default_timezone_set('Asia/Kolkata');
            $input['provider_id'] = Auth::user()->provider_id;
            $input['p_title']     = $r->p_title;
            $input['p_short_dec'] = $r->p_short_desc;
            $input['p_content']   = $pc;
            $input['uri']         = str_slug($r->p_title, "-");
            $input['created_at']  = Carbon::now(getenv('APP_TIMEZONE'));
            $input['updated_at']  = Carbon::now(getenv('APP_TIMEZONE'));
            $i_cat = [];

            foreach ($r->categories as $key => $value) {
                array_push($i_cat, $value['name']);
            }

            $input['categories'] = implode(',', $i_cat) . ",";
            $id                  = Post::insertGetId($input);
            foreach ($i_cat as $key => $cname) {
                $catmap              = new CategoryMap;
                $catmap->p_id        = $input['p_id'];
                $catmap->provider_id = $input['provider_id'];
                $catmap->c_name      = $cname;
                $catmap->save();
            }

            foreach ($r->documents as $doc) {
                Document::Where('document_id', $doc)->update(['p_id' => $input['p_id']]);   
            }

            foreach ($r->video as $v) {
                Video::Where('video_id', $v)->update(['p_id' => $input['p_id']]);   
            }

            return (['status' => '1']);

        } catch (Exception $e) {
            return (['status' => '0', 'error' => $e]);
        }


    }

    public function update(Request $r)
    {
        try {
            $input['p_id']        = $r->p_id;
            $input['provider_id'] = Auth::user()->provider_id;
            $input['p_title']     = $r->p_title;
            $pc = public_path().'/_p_content/'.$this->generateRandomString(50);
            file_put_contents($pc, $r->p_content);

            $input['p_short_dec'] = $r->p_short_desc;
            $input['p_content']   = $pc;
            $input['uri']         = str_slug($r->p_title, "-");
            $c_at                 = Post::select('created_at')->where('p_id', $r->p_id)->first();
            $input['created_at']  = $c_at['created_at'];
            $input['updated_at']  = Carbon::now(getenv('APP_TIMEZONE'));
            
            Post::where('p_id', $input['p_id'])->update(['is_latest' => '0']);
            $i_cat = [];

            foreach ($r->categories as $key => $value) {
                array_push($i_cat, $value['name']);
            }

            $input['categories'] = implode(',', $i_cat) . ",";
            $id                  = Post::insertGetId($input);
            $cats                = $r->categories;
            CategoryMap::where('p_id', $input['p_id'])->delete();
            foreach ($i_cat as $key => $cname) {
                $catmap              = new CategoryMap;
                $catmap->p_id        = $input['p_id'];
                $catmap->provider_id = $input['provider_id'];
                $catmap->c_name      = $cname;
                $catmap->save();
            }

            foreach ($r->documents as $doc) {
                Document::Where('document_id', $doc)->update(['p_id' => $input['p_id']]);   
            }

            foreach ($r->video as $v) {
                Video::Where('video_id', $v)->update(['p_id' => $input['p_id']]);   
            }

            return (['status' => '1']);

        } catch (Exception $e) {
            return (['status' => '0', 'error' => $e]);
        }
    }

    public function delete(Request $r)
    {
        try {

            Post::Where("p_id", $r->p_id)
                ->update([
                    "delete" => "1",
                ]);

            Document::Where("p_id", $r->p_id)->delete();

            return (['status' => '1']);
        } catch (Exception $e) {
            return (['status' => '0', 'error' => $e]);
        }
    }


}
