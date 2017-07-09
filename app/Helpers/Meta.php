<?php

namespace App\Helpers;
use Request;
use Session;
use Auth;
use Route;
use App\User;
use App\Document;
use App\Post;

class Meta
{
    public static function get(){
        
        $meta = [];
        $route = Route::currentRouteName();
        // dd(Route::parameters());
            if (Auth::check()) {
                $AuthUser = Auth::user();
                $meta = [
                        'email' => $AuthUser->email,
                        'firstName' => $AuthUser->first_name,
                        'lastName' => $AuthUser->last_name,
                        'gusermail' => $AuthUser->g_username,
                        'avatar'    => $AuthUser->avatar,
                        'website' => $AuthUser->website,
                        'bio' => $AuthUser->bio,
                        'gender' => $AuthUser->gender,
                        'birthday' => $AuthUser->birthday,
                        'mobileNumber' => $AuthUser->mobile_number,
                ];
            }
            // dd($route);
            switch ($route) {
                case 'indexroot':
                    $meta['title'] = "MakersLog | Light on what Makers Make";
                    $meta['pageName'] = "Search";
                    break;
                
                case 'createLog':
                    $meta['title'] = "New Log | MakersLog";
                    $meta['pageName'] = $AuthUser->first_name." ".$AuthUser->last_name." / New Log";
                    break;

                case 'editLog':
                    $meta['title'] = "Edit Log | MakersLog";
                    $meta['pageName'] = $AuthUser->first_name." ".$AuthUser->last_name." / Edit Log ";
                    break;

                case 'login':
                    $meta['title'] = "Login | MakersLog";
                    break;

                case 'gusermail':
                    $user = User::where('g_username', Request::route('gusermail'))->first();

                    $meta['title'] = "Logs from ".$user->first_name." ".$user->last_name." | MakersLog";
                    $meta['pageName'] = $user->first_name." ".$user->last_name;
                    break;

                case 'getProfile':
                    $meta['title'] = "Edit Profile | MakersLog";
                    $meta['pageName'] = $AuthUser->first_name." ".$AuthUser->last_name." / Edit Profile";
                    break;

                case 'documents':
                    $meta['title'] = "Documents | MakersLog";
                    $meta['pageName'] = $AuthUser->first_name." ".$AuthUser->last_name." / Documents";
                    break;

                case 'documentView':
                    $d = Document::where('googledrive_id', Request::route('googledrive_id'))->first();
                    $meta['title'] = "Document of ".$d['document_name']." | MakersLog";
                    $meta['pageName'] = "Document View";
                    $meta['gusermail'] = Request::route('gusermail');
                    break;
                    
                case 'individial':
                    $meta['pageName'] = str_replace("-", " ", Request::route('slug') );
                    $meta['title'] = $meta['pageName']. " | MakersLog";
                    break;

                case 'contributors':
                    $meta['title'] = "Contributors | MakersLog";
                    $meta['pageName'] = "Contributors";
                    break;
                                        
                default:
                    # code...
                    break;
            }
            return $meta;      
       
    }
}
