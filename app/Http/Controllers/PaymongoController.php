<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Item;
use Illuminate\Support\Facades\Http;

class PaymongoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       // 
    }

    public function creditcard(Request $request){

        return view('payment/creditcard');
    }

    public function _creditcard(Request $request){

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.base64_encode( config('paymongo')['secret_key'].':' )
        ])->post('https://api.paymongo.com/v1/payment_intents', [
            "data"=>[
                "attributes"=>[
                    "amount"=>50000,
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

        //print_r( $response);
        return response()->json([
            'status' => 1,
            'message'=>'',
            
            'data'=> [
                'paymentMethodId' => $response['data']['id'],
                'clientKey' => $response['data']['attributes']['client_key']
            ]
        ]);
        /**require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$response = $client->request('POST', 'https://api.paymongo.com/v1/payment_intents', [
  'body' => '{"data":{"attributes":{"amount":10000,"payment_method_allowed":["atome","card","dob","paymaya","billease"],"payment_method_options":{"card":{"request_three_d_secure":"any"}},"currency":"PHP","capture_type":"automatic"}}}',
  'headers' => [
    'Accept' => 'application/json',
    'Content-Type' => 'application/json',
  ],
]);

echo $response->getBody();
         */
    }
}
