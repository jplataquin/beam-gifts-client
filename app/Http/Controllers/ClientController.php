<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidateEmail;

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

    public function sendValidateEmail(Request $request){

        Mail::to('jp.lataquin@gmail.com')->send(new ValidateEmail());
    }
}
