<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\OrderItem;

class PaymongoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       // 
    }

    private function translateAmount($amount){
        
        //Scenario
        //100.1
        //100
        //100.01
        //100.0000
        
                
        $amount = $amount.'';

        $amountArr = explode('.',$amount);

        $translated = '';

        if(count($amountArr) >= 2){
            
            $translated .= $amountArr[0];
            $len        = strlen($amountArr[1]);
            
            if($len == 1){
                $translated .= $amountArr[1]+'0';
            }else if($len == 2){
                $translated .= $amountArr[1];
            }else{
                $translated .= substr($amountArr[1],0,2);
            }

        }else{
            $translated .= $amountArr[0]+'00';
        }

        return (int) $translated;
    }

    public function creditcard(Request $request,$uid){

      
        $order = new Order();

        $result = $order::where('uid',$uid)->where('status','PEND')->first();

        
        if(!$result){
            return abort(404);
        }
        
        //Validate order is not expired (More than 24 hours);
        $hours = round((strtotime('now') - strtotime($result->created_at))/3600, 1);

        if($hours > 24){
            return abort(404);
        }

        $result['calculation'] = json_decode($result['calculation']);
        
        return view('payment/creditcard',[
            'uid'       => $uid,
            'order'     => $result,
            'items'     => $result->items
        ]);
    }

    public function _creditcard(Request $request){

        $uid    = $request->input('uid');
        $order  = new Order();
        $result = $order::where('uid',$uid)->where('status','PEND')->first();

        if(!$result){
            return response()->json([
                'status'    => 0,
                'message'   =>'Order not found',
                'data'      => []
            ]);
        }

        if($result->payment_method != 'cc'){
            return response()->json([
                'status'    => 0,
                'message'   =>'Error in payment option',
                'data'      => []
            ]);
        }

        //pi_uyFGGxiTXWnqUrF4HBaNeWLt_client_C4uYzJd82LvLYaG3DXpBaWVC
        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic '.base64_encode( config('paymongo')['secret_key'].':' )
        ])->post('https://api.paymongo.com/v1/payment_intents', [
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

        //TODO VALIDATE $response['data']['attributes']['client_key']        
        //pi_uyFGGxiTXWnqUrF4HBaNeWLt_client_C4uYzJd82LvLYaG3DXpBaWVC
        $clientKey          = $response['data']['attributes']['client_key'];
        $payment_intent_id  = explode('_client',$clientKey)[0];

        $result->paymongo_payment_intent_id = $payment_intent_id;
        $result->paymongo_client_key        = $clientKey;

        $result->save();

        //print_r( $response);
        return response()->json([
            'status' => 1,
            'message'=>'',
            
            'data'=> [
                'clientKey'       => $clientKey,
                'pi'              => $payment_intent_id,
                'key'             => base64_encode( config('paymongo')['public_key'].':' ),
                'j' =>$response
            ]
        ]);
    }
}
