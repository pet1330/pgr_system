<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SAMLController extends Controller
{
	public function login()
	{
		return \Auth::guest() ? redirect('saml2/login') : \Redirect::intended('loggedin');
	}

	public function logout()
	{
	        Auth::logout();
                return redirect('saml2/logout');
	}

	public function loggedin()
	{
		return view('home');
	}
}
