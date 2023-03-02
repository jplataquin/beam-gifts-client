<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
//use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{


    public function index(Request $request,$category = null){

        $opt = '';

        if($category != null){

            $options = config('brand_categories')['options'];


            foreach($options as $key => $val){
                
                if( preg_replace( '/[[:space:]]+/', '-', strtolower($val) ) == $category){
                    $opt = $key;
                }
            }

            if($opt == ''){
                return abort(404);
            }
        }

        return view('brands',[
            'option' => $opt
        ]);
    }

    public function display($name)
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

    public function list(Request $request){

      
        $page       = $request->input('page') ?? 1;
        $category   = $request->input('category') ?? '';
        $query      = $request->input('query');
        $limit      = $request->input('limit') ?? 9;
       
        $order_by   = $request->input('sortBy') ?? '';
        $order      = $request->input('order');

        if(!in_array($order_by,['name','created_at'])){
            
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
        
        $brands = new Brand();

        $brands = $brands->where('status','=','ACTV');

        $result = [];
        
        if($category){
            $brands = $brands->where('category','=',$category);
        }

        if($query){
            $brands = $brands->where('name','LIKE','%'.$query.'%');
        }

        if($limit > 0){
            $page   = ($page-1) * $limit;

            if(!$random){
                $result = $brands->skip($page)->take($limit)->orderBy($order_by, $order)->get();
            }else{
                $result = $brands->skip($page)->take($limit)->orderBy(DB::raw('RAND()'))->get();
            }

        }else{

            if(!$random){
                $result = $brands->orderBy($order_by, $order)->get();
            }else{
                $result = $brands->orderBy(DB::raw('RAND()'))->get();
            }
        }
        

        for($i = 0; $i <= count($result) - 1; $i++){
            $result[$i]->photo      = json_decode($result[$i]->photo);
            $result[$i]->branches   = json_decode($result[$i]->branches);
        }
        
        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> $result
        ]);

    }
}

  