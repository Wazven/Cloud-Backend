<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Auth::routes(['verify' => true]);

Route::post('register', 'App\Http\Controllers\API\AuthController@register');
Route::post('login', 'App\Http\Controllers\API\AuthController@login');

Route::group(['middleware' => 'auth:api','verified'], function(){
    Route::get('recipe', 'App\Http\Controllers\RecipeController@index');
    Route::post('logout', 'App\Http\Controllers\API\AuthController@logout');
});
