<?php

namespace App\Http\Controllers;

use Bouncer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected function authorise($ability, $parameter=null)
    {
        if($parameter instanceof Model)
        {
            if( Bouncer::denies($ability, $parameter) && Bouncer::denies($ability, get_class($parameter)) )
                abort(403);
        }
        else
            if (Bouncer::denies($ability, $parameter) ) abort(403);
    }

    public function dashboard_url()
    {
        return redirect( auth()->user()->dashboard_url() );
    }
}
