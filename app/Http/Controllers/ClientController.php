<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

  

    public function validateEmail(Request $request){
        return view('validate_email',[
            'email' => Auth::user()->email
        ]);
    }

    
}
