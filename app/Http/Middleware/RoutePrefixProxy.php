<?php

namespace App\Http\Middleware;

use Closure;

class RoutePrefixProxy
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
        if (config('app.proxy_url')) {
            \URL::forceRootUrl(config('app.proxy_url'));
        }
        if (config('app.proxy_schema')) {
            \URL::forceScheme(config('app.proxy_schema'));
        }

        return $next($request);
    }
}
