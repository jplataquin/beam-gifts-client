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
            'id'        => $item->id,
            'name'      => $item->name,
            'price'     => $item->price,
            'quantity'  => $qty,
            'attributes' => [
                'image'     => $item->photo['150px']
            ],
            'associatedModel' => ' Item'
        ]);


        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> []
        ]);
    }

    public function updateCart(){

        \Cart::update(
            $request->id,
            [
                'quantity' => $quantity,
            ]
        );
    }

    public function removeCart(Request $request){
        \Cart::remove($request->id);
    }

    public function clearAllCart(){
        \Cart::clear();
    }

    public function checkout(Request $request){
        
        $user_id = Auth::user()->id;
        $items = \Cart::session($user_id)->getContent();

        $uid    =  hash('sha256', Str::random(6) .' - '.date('Y-m-d H:i:s') );
        $total  = 0;
        $bulk   = [];

        //TODO validate payment method
        //TODO Validate items

        foreach($items as $item){

            $itemModel = $item->model;

            //Get price from database;
            $total = $total + $itemModel->price;

            $bulk[] = [
                'uid'           => $uid,
                'brand_id'      => $itemModel->brand_id,
                'item_id'       => $itemModel->id,
                'brand_name'    => $itemModel->brand()->name,
                'name'          => $itemModel->name,
                'type'          => $itemModel->type,
                'category'      => $itemModel->category,
                'price'         => $itemModel->price,
                'expiry'        => $itemModel->expiry,
                'description'   => $itemModel->description
            ];
        }

      //  echo $request->paymentMethod;
       // print_r($items);

        $order = new Order();


        $order->uid             = $uid;
        $order->user_id         = $user_id;
        $order->amount          = $total;
        $order->status          = 'PEND';
        $order->payment_method  = $request->paymentMethod;

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


        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'uid'=>$uid
            ]
        ]);
    }
}