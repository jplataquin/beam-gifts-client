<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct(){

    
    }

    public function brand($name)
    {   

        echo Auth::check().'HERE ';

        $name = str_replace('-',' ',$name);
        $brand = new Brand();

        $result = $brand::where('name','=',$name)->where('status','=','ACTV')->first();
        
        if(!$result){
            return abort(404);
        }

        $result->photo      = json_decode($result->photo,true);
        $result->branches   = json_decode($result->branches,true);

        $items = new Item();

        $itemList = $items::where('brand_id',$result->id)->where('status','=','ACTV')->get();

        foreach($itemList as &$item){
            $item->photo = json_decode($item->photo,true);
        }

        return view('brand',[
            'brand' => $result,
            'items' => $itemList
        ]);
    }

    public function item($brandname,$itemname){

        $itemname   = str_replace('-',' ',$itemname);
        $brandname  = str_replace('-',' ',$brandname);
        
        $brand = new Brand();

        $brandResult = $brand::where('name','=',$brandname)->where('status','=','ACTV')->first();
        
        if(!$brandResult){
            return abort(404);
        }

        $brandResult->photo      = json_decode($brandResult->photo,true);
        $brandResult->branches   = json_decode($brandResult->branches,true);

        $item = new Item();

        $itemResult = $item::where('name','=',$itemname)
            ->where('status','=','ACTV')
            ->where('brand_id','=',$brandResult->id)
            ->first();
        
        if(!$itemResult){
            return abort(404);
        }

        $itemResult->photo = json_decode($itemResult->photo,true);
        
        return view('item',[
            'brand' => $brandResult,
            'item' => $itemResult
        ]);
    }
}
