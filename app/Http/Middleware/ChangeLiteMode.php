<?php

namespace App\Http\Middleware;

use Closure;

class ChangeLiteMode
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
        if (session()->has('lite_mode')) {
            // App::setLocale(session()->get('locale'));
        }
        return $next($request);
    }
}
