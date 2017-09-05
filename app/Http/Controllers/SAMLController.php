<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class SAMLController extends Controller
{
	public function login()
	{
		return Auth::guest() ? redirect('saml2/login') : redirect()->intended(Auth::user()->dashboard_url());
	}

	public function logout()
	{
	        Auth::logout();
                return redirect('saml2/logout');
	}
}
