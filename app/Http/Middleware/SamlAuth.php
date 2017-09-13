<?php

namespace App\Http\Middleware;

use Closure;

class SamlAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->guest())
		{
			if($request->ajax())
                return response('Unauthorized.', 401);
			return \Redirect::guest('login');
		}
		return $next($request);
    }
}
