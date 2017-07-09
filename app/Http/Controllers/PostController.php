<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Meta;
use Auth;
use App\Post;
use App\User;
use App\Document;

class PostController extends Controller
{
    public function index()
    {
        return view('newpost')
            ->with('meta', Meta::get('Kalpit Akhawat / New Log'));
    }

    public function individual($gusermail, $pid, $slug)
    {

        $aPost = Post::where('p_id', $pid)
            ->where('is_latest', '1')->where('delete', '0')->first();
        $doc = Document::where('p_id', $pid)->get();
        if ($aPost) {
            $userDetails = User::where('provider_id', $aPost->provider_id)->first();
            $aPost->p_content = file_get_contents($aPost->p_content);
            return view('individual')
                ->with('p', $aPost)
                ->with('doc', $doc)
                ->with('u', $userDetails)
                ->with('meta', Meta::get('Log'));
        } else {
            return '<h1>404 Not found.</h1>';
        }
    }

    public function validateInitial()
    {
        if (Auth::check()) {
            return (["say" => base64_encode("barobar che. agal java de")]);
        }
        return (["say" => base64_encode("bhai e back button maryu.")]);
    }
    public function update(Request $r,$id)
    {
      $provider_id=Auth::user()->provider_id;
      $post=Post::where('p_id',$id)->where('is_latest','1')->where('delete','0')->first();
      if ($post->provider_id != $provider_id) {
          return '<h1>404 Not Found</h1>';
      }
      $post->p_content = file_get_contents($post->p_content);
      $doc = Document::Select('*')->Where('p_id',$id)->get();
      //dd($post->categories);
      return view('editpost')->with('p',$post)->with('doc',$doc)->with('meta',Meta::get('Edit Log'));;
    }
}
