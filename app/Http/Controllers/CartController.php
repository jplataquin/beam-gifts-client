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
    
    public function __construct()
    {
        $this->middleware('auth');
       // 
    }

    public function cartList(Request $request){
        \Cart::session(Auth::user()->id);
       
        return view('cart',[
            'items' => \Cart::getContent(),
            'total' => \Cart::getTotal()
        ]);
    }

    public function addToCart(Request $request){

        \Cart::session(Auth::user()->id);

        $id    = (int) $request->input('id') ?? 0;
        $qty   = (int) $request->input('qty') ?? 0;

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
            ],
            'associatedModel' => Item::class
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

    public function removeCart(Request $request){
        \Cart::remove($request->id);

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'items' => \Cart::getContent(),
                'total' => \Cart::getTotal()
            ]
        ]);
    }

    public function clearAllCart(){
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
        //TODO Validate items

        foreach($items as $item){

            $itemModel = $item->model;

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


        $order = new Order();


        $order->uid             = $uid;
        $order->user_id         = $user_id;
        $order->amount          = $total;
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