<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CartController extends Controller
{

    public function cartList(Request $request){

        \Cart::session(Auth::user()->id); 


        $total = \Cart::getTotal();

        //CC
        $cc = $this->calculation('cc',$total);

        //GC
        $gc = $this->calculation('gc',$total);

        return view('cart',[
            'items'                 => \Cart::getContent(),
            'total'                 => $total,
            'service_fee'           => $cc['service_fee'],
            'paymentCalculation'    => [
                'cc' => [
                    'payment_processor_fee' => $cc['payment_processor_fee'],
                    'grand_total'           => $cc['grand_total']
                ],
                'gc' => [
                    'payment_processor_fee' => $gc['payment_processor_fee'],
                    'grand_total'           => $gc['grand_total']
                ]
            ] 
        ]);
    }

    public function addToCart(Request $request){

        \Cart::session(Auth::user()->id);

        $id    = (int) $request->input('id') ?? 0;
        $qty   = (int) $request->input('qty') ?? 0;

        $count = count(\Cart::getContent());

        if($count >= 10){
            return response()->json([
                'status' => 0,
                'message'=>'There is a maximum limit of 10 items per cart',
                'data'=> []
            ]);
        }

        $item = new Item();

        $item = $item::where('id', $id)->where('status','ACTV')->first();

        if(!$item){
            return response()->json([
                'status' => 0,
                'message'=>'Sorry but the item no longer available',
                'data'=> []
            ]);
        }

        //todo quantity and limit validation
        if(!$qty){
            return response()->json([
                'status' => 0,
                'message'=>'Minimum of at least one quantity is required',
                'data'=> []
            ]);
        }

        $item->photo = json_decode($item->photo,true);

        \Cart::add([
            'id'        => mt_rand(100000, 999999),
            'name'      => $item->name,
            'price'     => $item->price,
            'quantity'  => $qty,
            'attributes' => [
                'image'     => $item->photo['150px'],
                'item_id'   => $item->id
            ]
        ]);


        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'items' => \Cart::getContent(),
                'total' => \Cart::getTotal()
            ]
        ]);
    }

    public function updateCart(Request $request){

        \Cart::update(
            $request->id,
            [
                'quantity' => $quantity,
            ]
        );
    }

    private function calculation($type,$total){
       
        $payment = config('payment');
        
        $service_fee  = $payment['service_fee'];

        if($type == 'cc'){
            //CC
            $payment_processor_fee_cc       = $payment['payment_processor_fee']['cc']($total + $service_fee);
            $grand_total_cc                 = $total + $service_fee + $payment_processor_fee_cc;

            return [
                'total'                 => $total,
                'service_fee'           => $service_fee,
                'payment_processor_fee' => $payment_processor_fee_cc,
                'grand_total'           => $grand_total_cc,
                'order'                 => ['total','service_fee','payment_processor_fee','grand_total']
            ];
        }
        
        if($type == 'gc'){

            //GC
            $payment_processor_fee_gc       = $payment['payment_processor_fee']['gc']($total + $service_fee);
            $grand_total_gc                 = $total + $service_fee + $payment_processor_fee_gc;
            
            return [
                'total'                 => $total,
                'service_fee'           => $service_fee,
                'payment_processor_fee' => $payment_processor_fee_gc,
                'grand_total'           => $grand_total_gc,
                'order'                 => ['total','service_fee','payment_processor_fee','grand_total']
            ];
        }
        
    }


    public function removeCart(Request $request){
        
        if(!$request->id){
            return response()->json([
                'status' => 0,
                'message'=> 'Item ID is required for this operation',
                'data'=> []
            ]);
        }


        $cart = \Cart::session(Auth::user()->id);
        
        $cart->remove($request->id);

        $total = $cart->getTotal();

        //CC
        $cc = $this->calculation('cc',$total);

        //GC
        $gc = $this->calculation('gc',$total);

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'id'    => $request->id,
                'items' => $cart->getContent(),
                'total' => $total,
                'paymentCalculation'    => [
                    'cc' => [
                        'payment_processor_fee' => $cc['payment_processor_fee'],
                        'grand_total'           => $cc['grand_total']
                    ],
                    'gc' => [
                        'payment_processor_fee' => $gc['payment_processor_fee'],
                        'grand_total'           => $gc['grand_total']
                    ]
                ]
            ]
        ]);
    }

    public function clearAllCart(){

        \Cart::session(Auth::user()->id); 
        \Cart::clear();

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'items' => \Cart::getContent(),
                'total' => \Cart::getTotal()
            ]
        ]);
    }

    public function checkout(Request $request){
        
        $user_id = Auth::user()->id;
        $items = \Cart::session($user_id)->getContent();

        
        $at             = date('Y-m-d H:i:s');
        $uid            = hash('sha256', Str::random(6) .' - '.$at );
        $total          = 0;
        $bulk           = [];
        $paymentMethod  = $request->paymentMethod;

        //TODO validate payment method
        if(!in_array($paymentMethod,['cc','gc'])){
            return response()->json([
                'status' => 1,
                'message'=>'Unsupported payment method',
                'data'=> []
            ]);
        }

        foreach($items as $item){

            $itemModel = Item::findOrFail($item->attributes->item_id);
            
            
            //TODO Validate items

            //Get price from database;
            $total = $total + ($itemModel->price * $item->quantity);

            $bulk[] = [
                'uid'           => $uid,
                'status'        => 'PEND',
                'brand_id'      => $itemModel->brand_id,
                'item_id'       => $itemModel->id,
                'quantity'      => $item->quantity,
                'brand_name'    => $itemModel->brand->name,
                'item_name'     => $itemModel->name,
                'type'          => $itemModel->type,
                'category'      => $itemModel->category,
                'price'         => $itemModel->price,
                'expiry'        => $itemModel->expiry,
                'description'   => $itemModel->description,
                'logs'          => json_encode([]),
                'created_at'    => $at,
                'updated_at'    => $at
            ];
        }


        $calculation = $this->calculation($paymentMethod,$total);


        
        $order = new Order();


        $order->uid             = $uid;
        $order->user_id         = $user_id;
        $order->amount          = $calculation['grand_total'];
        $order->calculation     = json_encode($calculation);
        $order->status          = 'PEND';
        $order->payment_method  = $paymentMethod;

        $orderItem = new OrderItem();

        try{
 
            DB::transaction(function () use($order,$bulk){

                $order->save();

                OrderItem::insert($bulk);

            });
            
        }catch(\Exception $e){

            return response()->json([
                'status' => 0,
                'message'=> $e,
                'data'=> []
            ]);
        }

        //Clear cart
        \Cart::clear();

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'uid'       => $uid,
                'method'    => $paymentMethod
            ]
        ]);

    }
}