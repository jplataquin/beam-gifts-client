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
        
        $response = $client->request('GET', 'https://api.paymongo.com/v1/payment_intents/id', [

        'headers' => [

            'Accept' => 'application/json',

        ],

        ]);


        echo $response->getBody();
    }

    private function validatePaymongoPayment($order){

        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic '.base64_encode( config('paymongo')['secret_key'].':' )
        ])->get('https://api.paymongo.com/v1/payment_intents/id', [
            "data"=>[
                "attributes"=>[
                    "amount"=> $this->translateAmount($result->amount),
                    "payment_method_allowed"=>["card"],
                    "payment_method_options"=>[
                        "card"=>[
                            "request_three_d_secure"=>"any"
                        ]
                    ],
                    "currency"=>"PHP",
                    "capture_type"=>"automatic"
                ]
            ]
        ])->json();

    }
}
