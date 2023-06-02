<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\recipe;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function index(){
        $recipe = Recipe::all();
        if(count($recipe) > 0){
            return response([

                'data' => $recipe
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); 
    }

}