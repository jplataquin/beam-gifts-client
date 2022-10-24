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

            if ($request->wantsJson()) {
                
                return response()->json([
                    'status' => -2,
                    'message'=>'You must be logged in to access this feature',
                    'data'=> []
                ]);

            } else {
                return redirect('validate/email');
            }
            
        }

        $user = Auth::user();

        if(!$user->email_confirmed){

            if ($request->wantsJson()) {
                
                return response()->json([
                    'status' => -2,
                    'message'=>'Please validate your email before using this feature',
                    'data'=> []
                ]);

            } else {
                return redirect('validate/email');
            }

          
        }

        return $next($request);
    }
}
