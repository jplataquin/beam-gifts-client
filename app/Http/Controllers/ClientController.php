<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

  

    public function brand($name)
    {   

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

    
}
