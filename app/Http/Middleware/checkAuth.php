<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class checkAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $user = Auth::user()){
            return response()->json(['status'=>false , 'message'=>"Unauthorized"],401);
            // return response("Unauthenticated",401);
        }
        return $next($request);
    }
}
