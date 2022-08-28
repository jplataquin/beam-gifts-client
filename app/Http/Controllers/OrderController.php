<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    
    public function index(Request $request,$uid){

        $order = new Order();

        $order = $order::where('uid',$uid)->first();

        if(!$order){
            abort(404);
        }

        if($order->status == "PEND"){
            $this->validatePaymongoPayment($order);
        }
       
    }

    private function validatePaymongoPayment($order){

        if($order->paymongo_payment_intent_id){
            
            try{
                $response = Http::withHeaders([
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic '.base64_encode( config('paymongo')['secret_key'].':' )
                ])->get('https://api.paymongo.com/v1/payment_intents/'.$order->paymongo_payment_intent_id, [])->throw()->json();
                
                $status = $response['data']['attributes']['status'];

                if($status == 'succeeded'){
                    $order->status = 'PAID';
                    $order->paymongo_payment_intent_data = json_encode($response);
                }

                $order->save();

            }catch(\Exception $e){
                //TODO
            }
        }
    }
}
