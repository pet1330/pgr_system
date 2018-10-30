<?php

namespace App\Http\Middleware;

use Closure;

class DevUser
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
        if (\App::environment() === 'local' && ! auth()->check()) {
            $hack_user = getenv('HACK_USER');
            if (! empty($hack_user)) {
                auth()->loginUsingId(\App\Models\User::where('university_id', $hack_user)->first()->id);
            }
        }
        $hack_user = $request->input('hack_user');
        if (! empty($hack_user)) {
            auth()->loginUsingId(\App\Models\User::where('university_id', $hack_user)->first()->id);
        } 
	
        return $next($request);
    }
}
