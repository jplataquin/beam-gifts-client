<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class GiftController extends Controller
{
    
    public function index(Request $request){
        return view('gift_list');
    }

    public function qr($order_uid,$item_uid){

        $order     = new Order();
        $orderItem = new OrderItem();
        $user      = new User();

        $order = $order::where('uid',$order_uid)->where('status','PAID')->first();

        if(!$order){

            return abort(404);
        }

        $orderItem = $orderItem::where('status','AVLB')->where('uid',$order_uid)->where('item_uid',$item_uid)->first();

        if(!$orderItem){
            return abort(404);
        }

        $user = $user::find($orderItem->user_id);
        
        return view('qr_display',[
            'item'  => $orderItem,
            'brand' => $orderItem->model->brand,
            'user'  => $user,
            'photo' => json_decode($orderItem->model->photo,true)
        ]);

    }


    public function list(Request $request){

        $user_id = Auth::user()->id;

        $limit  = (int) $request->input('limit') ?? 0;
        $page   = (int) $request->input('page') ?? 0;
        $brand  = $request->input('brand');
        $status = $request->input('status');

        if($limit > 0){
            $page   = $page * $limit;
        }
        
        $result = DB::table('order_items')
            ->join('orders', function ($join) use($user_id) {
                
                $join->on('orders.uid', '=', 'order_items.uid')
                    ->where('orders.user_id', '=', $user_id)
                    ->where('orders.status', '=', 'PAID');

                //$join->on('items.id','=','order_items.item_id');
            })
            ->skip($page)->take($limit)
            ->select('order_items.*', 'orders.uid');
            
        if($status){
            $result = $result->where('order_items.status',$status);
        }
            
        if($brand){
            $result = $result->where('order_items.brand_name','LIKE','%'.$brand.'%');
        }

        $result = $result->get();

        //Workaround because I cannot add items table to join yet
        $item_data = [];
        for($i = 0; $i <= count($result) - 1; $i++){

            $id = $result[$i]->item_id;

            if(! isset($item_data[$id]) ){
                $item_data[$id] = Item::find($id);
            }
            
            $result[$i]->photo = json_decode($item_data[$id]->photo,true);
        }

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'items' => $result
            ]
        ]);
    }

    public function tictactoe(Request $request){
        return view('tictactoe');
    }
}
