<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
//use App\Models\Item;
//use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{


    public function index(Request $request){
        return view('gifts');
    }

    public function list(Request $request){

        $page       = $request->input('page') ?? 1;
        $category   = $request->input('category') ?? '';
        $query      = $request->input('query');
        $limit      = $request->input('limit') ?? 9;
       
        $order_by   = $request->input('sortBy') ?? '';
        $order      = $request->input('order');

        if(!in_array($order_by,['name','created_at','price'])){
            
            $order_by = 'created_at';
        }

        $random = false;

        if(!in_array($order,['DESC','ASC','RAND'])){
            $order = 'DESC';
        }

        if($order == 'RAND'){
            $random = true;
        }

        $limit = (int) $limit;
        
        $items = new Item();

        $items = $items->where('status','=','ACTV');

        $result = [];
        
        if($category){
            $items = $items->where('category','=',$category);
        }

        if($query){
            $items = $items->where('name','LIKE','%'.$query.'%');
        }

        if($limit > 0){
            $page   = ($page-1) * $limit;

            if(!$random){
                $result = $items->skip($page)->take($limit)->orderBy($order_by, $order)->get();
            }else{
                $result = $items->skip($page)->take($limit)->orderBy(DB::raw('RAND()'))->get();
            }

        }else{

            if(!$random){
                $result = $items->orderBy($order_by, $order)->get();
            }else{
                $result = $items->orderBy(DB::raw('RAND()'))->get();
            }
        }
        

        for($i = 0; $i <= count($result) - 1; $i++){
            $result[$i]->photo      = json_decode($result[$i]->photo);
        }
        
        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> $result
        ]);

    }
}

  