<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
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
        $limit      = 9;
        
        $brands = new Brand();

        $brands = $brands->where('status','=','ACTV');

        $result = [];
        
        if($category){
            $brands = $brands->where('category','=',$category);
        }

        if($limit > 0){
            $page   = ($page-1) * $limit;
            $result = $brands->skip($page)->take($limit)->orderBy('created_at', 'desc')->get();
        }else{
            $result = $brands->orderBy('created_at', 'desc')->get();
        }
        

        for($i = 0; $i <= count($result) - 1; $i++){
            $result[$i]->photo = json_decode($result[$i]->photo);
            $result[$i]->branches = json_decode($result[$i]->branches);
        }
        
        return response()->json([
            'status' => 1,
            'message'=>'',
            'data'=> $result
        ]);

    }
}

  