<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Item;


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
            'associatedModel' => 'Item'
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
        
        $items = \Cart::session(Auth::user()->id)->getContent();

        echo $request->paymentMethod;
        print_r($items);
    }
}