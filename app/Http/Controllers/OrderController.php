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

    public function index(){
        return view('order_list');
    }

    public function display(Request $request,$uid){

        $user_id = Auth::user()->id;

        $order = new Order();

        $order = $order::where('uid',$uid)->where('user_id',$user_id)->first();

        if(!$order){
            abort(404);
        }

        if($order->status == 'PEND' || $order->status == ''){
            $order = $this->validatePaymongoPayment($order);
        }

        $date_created   = date('M d, Y H:i:s',strtotime($order->created_at));
        $date_paid      = 'N/A';
        $payment_intent = [];
        $payment_method = '';

        if($order->status == 'PEND'){
         
        }else if($order->status == 'PAID'){
            
        
            $payment_intent = json_decode($order->paymongo_payment_intent_data,true);

            $payment_time   = (int) $payment_intent['data']['attributes']['payments'][0]['attributes']['paid_at'];
            $date_paid      = date('M d, Y H:i:s',$payment_time);
        }


        $payment_method_opt = [
            'cc' => 'Credit Card',
            'gc' => 'Gcash'
        ];

        $payment_method = $payment_method_opt[$order->payment_method];

        return view('order',[
            'order'             => $order,
            'items'             => $order->items,
            'payment_intent'    => $payment_intent,
            'date_created'      => $date_created,
            'date_paid'         => $date_paid,
            'payment_method'    => $payment_method,
            'calculation'       => json_decode($order->calculation)
        ]);
    }

    public function list(Request $request){

        $user_id = Auth::user()->id;

        $limit              = (int) $request->input('limit') ?? 0;
        $page               = (int) $request->input('page') ?? 0;
        $date_created_order = $request->input('date_created_order') ?? 'desc';
        $status             = $request->input('status') ?? '';

        $order = new Order();

        $order = $order->where('user_id',$user_id);

        if($status){
            $order = $order->where('status',$status);
        }
       
        
        if($limit > 0){
            $page   = $page * $limit;
            $result = $order->skip($page)->take($limit)->orderBy('created_at', $date_created_order)->get();
        }else{
            $result = $order->orderBy('created_at', $date_created_order)->get();
        }

        foreach($result as $i => $row){
            $result[ $i ]['calculation'] = json_decode($result[ $i ]['calculation'],true);
        }

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'orders' => $result,
                'status' => $status
            ]
        ]);
    }

    private function validatePaymongoPayment($order){

        if($order->paymongo_payment_intent_id){
            
            try{

                $response = Http::withHeaders([
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic '.base64_encode( config('paymongo')['secret_key'].':' )
                ])->get('https://api.paymongo.com/v1/payment_intents/'.$order->paymongo_payment_intent_id, [])
                ->throw()
                ->json();
                
                $status = $response['data']['attributes']['status'];
                
                $payment_time   = (int) $response['data']['attributes']['payments'][0]['attributes']['paid_at'];
                $date_paid      = date('Y-m-d H:i:s',$payment_time);

                if($status == 'succeeded'){
                    $order->status = 'PAID';
                    $order->paymongo_payment_intent_data = json_encode($response);
                    
                    DB::transaction(function () use ($order,$date_paid,$payment_time){

                        $order->save();
                        
                        DB::table('order_items')->where('uid',$order->uid)->update([
                            'item_uid'      => DB::raw('SHA2(CONCAT( order_items.id, "'.$order->uid.'", order_items.item_name ), 256)'),
                            'status'        => 'AVLB',
                            'user_id'       => $order->user_id,
                            'paid_at'       => $date_paid,
                            'updated_at'    => date('Y-m-d H:i:s'),
                            'expires_at'    => DB::raw('DATE_ADD("'.$date_paid.'",INTERVAL order_items.expiry DAY)'),
                            'logs'          => json_encode([])
                        ]);
                       
    
                    });
                }

                
            }catch(\Exception $e){
                //TODO throw error here
                throw $e;
            }
        }

        return $order;
    }
}
