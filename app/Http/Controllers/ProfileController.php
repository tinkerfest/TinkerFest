<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Helpers\Meta;
use App\User;
use Auth;
use Session;
use Redirect;


class ProfileController extends Controller
{
    public function index($gusermail) {
    	if(Auth::check() &&  Auth::user()->g_username == $gusermail ) {
    		return view('profile')
                ->with('meta',Meta::get('Kalpit Akhawat / New Log'));
    	}
    	else {
    		return redirect(route('gusermail', ['gusermail' => $gusermail]));
    	}
    }

    public function store(Request $request, $gusermail) {
    	User::where("g_username", $gusermail)->update([
            "first_name" => $request->firstName,
	    	"last_name" => $request->lastName,
	    	"email" => $request->email,
	    	"g_username" => $request->gusermail,
	    	"bio" => $request->bio,
	    	//"avatar" => $request->avatar,
	    	"website" => $request->website,
	    	"gender" => $request->gender,
	    	"birthday" => $request->birthday,
	    	"mobile_number" => $request->mobileNumber,
        ]);
    	return redirect( route('getProfile', ['gusermail' => $request->gusermail]) );
    }

}