<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\recipe;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function index(Request $request){

        $data = Validator::make($request->all(), [
            'page' => 'required|integer',
            'size' => 'required|integer'
        ]);

        if($data->fails()){
            return response([
                'message' => 'Failed',
                'data' => $data->errors()
            ], 400);
        }

        $page = $request->page;
        $size = $request->size;

        $recipe = recipe::skip(($page-1)*$size)->take($size)->get();
        
        // $recipe = recipe::where('name','=','Sauteed Bananas with Cardamom Praline Sauce')->get();
        
        if(count($recipe) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $recipe
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }
    
}
