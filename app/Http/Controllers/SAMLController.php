<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SAMLController extends Controller
{
	public function login()
	{
		return auth()->guest() ? redirect('saml2/login') : redirect()->intended(auth()->user()->dashboard_url());
	}

	public function logout()
	{
		auth()->logout();
        session()->save();
        return redirect('saml2/logout');
	}
}
