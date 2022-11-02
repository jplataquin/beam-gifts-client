<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidateEmail;
use Illuminate\Support\Str;

class ClientController extends Controller
{

    public function email(Request $request){
        return view('validate_email',[
            'email' => Auth::user()->email
        ]);
    }


    public function validateEmail(Request $request,$token){
        
        $user = new User();
        
        $user = $user::where('email_token','=',$token)->where('email_confirmed','=',false)->first();
        
        if(!$user){
            return abort(404);
        }

        $user->email_confirmed      = true;
        $user->email_verified_at    = date('Y-m-d H:i:s');
        $user->save();

        return view('successful_email_validation',$user);
    }


    public function profile(Request $request){

        return view('profile',Auth::user());
    }


    public function resendEmailValidation(Request $request){
        
        $user           = Auth::user();
        $email_token    = Str::random(64);
        
        if($user->email_confirmed){

            return response()->json([
                'status'    => 0,
                'message'   =>'Ops! It seems your email has already been verified',
                'data'      => []
            ]);
        }

        $user->email_token = $email_token;

        $user->save();

        Mail::to($user->email)->send(new ValidateEmail([
            'email' => $data['email'],
            'token' => $email_token
        ]));

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> []
        ]);
    }
}
