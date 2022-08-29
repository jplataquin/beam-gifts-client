<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $status         = '';
        $date_created   = date('M d, Y H:i:s',strtotime($order->created_at));
        $date_paid      = 'N/A';
        $payment_intent = [];
        $payment_method = '';

        if($order->status == 'PEND'){
            $status = 'Not Paid';
        }else if($order->status == 'PAID'){
            
            $status         = 'Paid';
            $payment_intent = json_decode($order->paymongo_payment_intent_data,true);

            //print_r($payment_intent);
            //exit;
            $payment_time   = (int) $payment_intent['data']['attributes']['payments'][0]['attributes']['paid_at'];
            $date_paid      = date('M d, Y H:i:s',$payment_time);
        }


        $payment_method_opt = [
            'cc' => 'Credit Card',
            'gc' => 'Gcash'
        ];

        $payment_method = $payment_method_opt[$order->payment_method];

        return view('order',[
            'status'            => $status,
            'order'             => $order,
            'items'             => $order->items,
            'payment_intent'    => $payment_intent,
            'date_created'      => $date_created,
            'date_paid'         => $date_paid,
            'payment_method'    => $payment_method
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

                DB::transaction(function () use($order){

                    $order->save();
                    
                    DB::table('order_items')->where('uid',$order->uid)->update([
                        'status'    => 'PAID',
                        'user_id'   => $order->user_id,
                    ]);

                });
               

            }catch(\Exception $e){
                //TODO throw error here
            }
        }
    }
}
