<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    
    public function index(Request $request,$uid){

        $user_id = Auth::user()->id;

        $order = new Order();

        $order = $order::where('uid',$uid)->where('user_id',$user_id)->first();

        if(!$order){
            abort(404);
        }

        if($order->status == "PEND"){
            $this->validatePaymongoPayment($order);
        }

        $status = '';

        if($order->status == 'PEND'){
            $status = 'Not Paid';
        }else if($order->status == 'PAID'){
            $status = 'Paid';
        }

        return view('order',[
            'status'    => $status,
            'order'     => $order,
            'items'     => $order->items,
            'payment_intent' => json_decode($order->payment_intent_data,true)
        ]);
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
                //TODO throw error here
            }
        }
    }
}
