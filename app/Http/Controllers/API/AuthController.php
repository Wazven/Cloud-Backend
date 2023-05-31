<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Laravel\Passport\Token;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $registerData = $request->all();
        $validate = Validator::make($registerData, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'weight' => 'required',
            'height' => 'required',
            'password' => 'required|min:6|max:255'
        ]);
        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()], 400);
        }
        $registerData['password'] = bcrypt($registerData['password']);
        $user = User::create($registerData);
        return response()->json([
            'status' => 'success',
            'message' => 'Register Berhasil!',
            'data' => $user
        ], 200);
    }

// public function login (Request $request){
//     $loginData = $request->all();

//     $validate = Validator::make($loginData, [
//         'name' => 'required',
//         'password' => 'required'
//     ]);

//     if($validate->fails())
//         return response(['message'=> $validate->errors()->first(),'errors' => $validate->errors()], 400);

//     if(!Auth::attempt($loginData))
//         return response(['message' => 'Invalid Credentials', 'data'=>$loginData], 401);

//     $user = Auth::user();
//     $token = $user->createToken('Authentication Token')->accessToken;
//     return response([
//         'message' => 'Authenticated',
//         'user' => $user,
//         'token_type' => 'Bearer',
//         'access_token' => $token
//     ]);
// }

public function login (Request $request){
    $loginData = $request->all();
    //$status = 0;

    $validate = Validator::make($loginData, [
        'name' => 'required',
        'password' => 'required'
    ]);

    if($validate->fails())
        return response(['message' => $validate->errors()], 400);

    if(Auth::guard('web')->attempt($loginData)){
        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken;   //generate token

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token,
        ]);
    }else{
        return response(['message' => 'Invalid Credentials user'], 401);  // Mengembalikan error gagal login
    }
    return new ResourceUser(true, 'User berhasil login', $response);
}

public function logout(Request $request){
    $user = Auth::user()->token();
    $dataUser = Auth::user();
    $user->revoke();
    return response([
        'message' => 'Logout Success',
        'user' => $dataUser
    ]);
}
}