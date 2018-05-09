<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function login()
    {
        return auth()->guest() ? redirect()->route('login') : redirect()->intended();
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }
}
