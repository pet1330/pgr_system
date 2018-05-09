<?php

namespace App\Http\Controllers;

class SAMLController extends Controller
{
    public function login()
    {
        return auth()->guest() ? redirect()->route('saml_login') : redirect()->intended();
    }

    public function logout()
    {
        auth()->logout();
        session()->save();

        return redirect()->route('saml_logout');
    }
}
