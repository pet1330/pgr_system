<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SAMLController extends Controller
{
	public function login()
	{
		return auth()->guest() ? redirect()->route('login') : redirect()->intended(auth()->user()->dashboard_url());
	}

	public function logout()
	{
		auth()->logout();
        session()->save();
        return redirect()->route('logout');
	}
}
