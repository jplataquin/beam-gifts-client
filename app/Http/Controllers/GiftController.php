<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
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

        $order = $order::where('uid',$order_uid)->first();

        if(!$order){

            return 'HERE 1';
        }

        $orderItem = $orderItem::where('status','AVLB')->where('uid',$order_uid)->where('item_uid',$item_uid)->first();

        if(!$orderItem){
            return 'HERE 2';
        }

        $user = $user::find($orderItem->user_id);
        
        return view('qr_display',[
            'item'  => $orderItem,
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
