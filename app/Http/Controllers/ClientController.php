<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidateEmail;

class ClientController extends Controller
{

    public function validateEmail(Request $request){
        return view('validate_email',[
            'email' => Auth::user()->email
        ]);
    }

    public function sendValidateEmail(Request $request){

        Mail::to('jp.lataquin@gmail.com')->send(new ValidateEmail());
    }
}
