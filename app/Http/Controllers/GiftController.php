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

    public function qr($item_uid){

        $orderItem = new OrderItem;
        $user      = new User;

        $orderItem = $orderItem::where('status','PAID')->where('item_uid',$item_uid)->first();

        if(!$orderItem){
            return abort(404);
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

        
        $result = DB::table('order_items')
            ->join('orders', function ($join) {
                $join->on('orders.uid', '=', 'order_items.uid')
                    ->where('orders.user_id', '=', $user_id)
                    ->where('orders.status', '=', 'PAID');
            })
            ->select('order_items.*', 'orders.uid')
            ->get();

        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> [
                'items' => $result
            ]
        ]);
    }
}
