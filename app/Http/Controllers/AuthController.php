<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;

class AuthController extends Controller
{
    public function login()
    {
        return Auth::guest() ? redirect('saml2/login') : Redirect::intended();
    }

    public function logout()
    {
            \Auth::logout();
            return redirect('/');
    }
}
