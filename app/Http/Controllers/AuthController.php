<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aacotroneo\Saml2\Saml2Auth;
use Aacotroneo\Saml2\Http\Controllers\Saml2Controller;

class AuthController extends Saml2Controller
{

    /**
     * Initiate a logout request across all the SSO infrastructure.
     *
     * @param Saml2Auth $saml2Auth
     * @param Request $request
     */
    public function logout(Saml2Auth $saml2Auth, Request $request)
    {
        auth()->logout();
        session()->save();
        parent::logout($saml2Auth, $request); // does not return
    }

    /**
     * Initiate a login request.
     *
     * @param Saml2Auth $saml2Auth
     */
    public function login(Saml2Auth $saml2Auth)
    {
        return auth()->guest() ? parent::login($saml2Auth) : redirect()->intended(config('app.url_prefix', ''));
    }
}
