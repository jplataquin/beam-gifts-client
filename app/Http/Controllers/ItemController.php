<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ItemController extends Controller
{
    
    public function index($item_uid){

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
}
