<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    function __construct()
    {
        config(['auth.defaults.guard' => 'admin']);
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->guard('admin')->check()) {

            // dd('ddd');
            return redirect()->route('admin-home');
            // return redirect()->intended(route('admin-home'));
        }

        return $next($request);
    }
}
