<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    
    public function index(Request $request,$uid){

        $order = Order::findOrFail($uid);

        if($order->status == "PEND"){
            $this->validatePaymongoPayment($order);
        }
       
    }

    private function validatePaymongoPayment($order){

        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic '.base64_encode( config('paymongo')['secret_key'].':' )
        ])->get('https://api.paymongo.com/v1/payment_intents/'.$order->paymongo_payment_intent_id, [])->json();

        echo $response->data->attributes->status;
    }
}
