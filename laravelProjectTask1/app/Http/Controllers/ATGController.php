<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\registerusers;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Input;

class ATGController extends Controller
{
    //Form DIsplay
    public function register()
    {
        return view('ATG.register');
    }

    public function postregister(Request $req)
    {
        
        $rules = array (
				 
				'name' => 'required',
	            'email' => 'required|email',
	            'pincode' => 'required|min:6|max:6'
		);
        $validator = Validator::make ( Input::all (), $rules );
        //dd($validator);
		if ($validator->fails ()) {
			return Redirect::back()->withErrors( $validator );
			//return Redirect::back()->withErrors(['msg', 'The Message']);
			
		}else{
			$register = new registerusers();
			$register->name = $req->get ( 'name' );
			$register->email = $req->get ( 'email' );
			$register->pincode =  $req->get ( 'pincode' ) ;
			$register->remember_token = $req->get ( 'remember_token' );
			if (registerusers::where('email', '=', $req->get ( 'email' ))->exists()) {
				return Redirect::back()->withErrors(['Email Already Exist']);
			}else{
			$register->save ();
		
			return Redirect::back()->with('message', 'Added Successfully.');
			}
		}
    }

    
}
