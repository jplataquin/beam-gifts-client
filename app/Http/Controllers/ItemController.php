<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    
    public function index($item_uid){

        $orderItem = new OrderItem;

        $orderItem = $orderItem::where('status','PAID')->where('item_uid',$item_uid)->first();

        if(!$orderItem){
            return abort(404);
        }

        return view('qr_display',[
            'item'  => $orderItem,
            'photo' => json_decode($orderItem->model->photo,true)
        ]);

    }
}
