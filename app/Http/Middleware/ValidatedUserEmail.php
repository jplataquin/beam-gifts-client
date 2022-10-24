<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidatedUserEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
         
        if(!Auth::check()){

            return response()->json([
                'status' => 0,
                'message'=>'You must be logged in to access this feature',
                'data'=> []
            ]);
        }

        $user = Auth::user();

        if(!$user->email_confirmed){
            return response()->json([
                'status' => 0,
                'message'=>'Please validate your email before using this feature',
                'data'=> []
            ]);
        }

        return $next($request);
    }
}
