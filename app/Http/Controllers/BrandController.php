<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
//use App\Models\Item;
//use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{


    public function index(Request $request){
        return view('brands');
    }

    public function list(Request $request){

        $page       = $request->input('page') ?? 1;
        $category   = $request->input('category') ?? '';
        $query      = $request->input('query');
        $limit      = $request->input('limit') ?? 9;
        $random     = $request->input('random') ?? false;
        $order_by   = $request->input('orderBy') ?? '';

        if(!in_array($order_by,['name','created_at'])){
            
            $order_by = 'created_at';
        }

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
                $result = $brands->skip($page)->take($limit)->orderBy($order_by, 'desc')->get();
            }else{
                $result = $brands->skip($page)->take($limit)->orderBy(DB::raw('RAND()'))->get();
            }

        }else{

            if(!$random){
                $result = $brands->orderBy($order_by, 'desc')->get();
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

  