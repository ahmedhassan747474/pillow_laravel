<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Route;

class RideUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'api')
    {
        if(Auth::guard($guard)->check())
        {
            if(Auth::guard($guard)->user()->user_type != 2)
            {
                return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
            }
        } 
        
        return $next($request);
    }
}
