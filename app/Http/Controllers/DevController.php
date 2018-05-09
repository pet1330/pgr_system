<?php

namespace App\Http\Controllers;

class DevController extends Controller
{
    public function authStatus()
    {
        return auth()->check() ? 'logged-in' : 'logged-out';
    }

    public function downtimeRobot()
    {
        return 'All Systems Operational';
    }

    public function accountLocked()
    {
        return 'SORRY! YOUR ACCOUNT APPEARS TO HAVE BEEN LOCKED';
    }
}
