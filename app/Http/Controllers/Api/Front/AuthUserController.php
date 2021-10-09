<?php

namespace App\Http\Controllers\Api\Front;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;

class AuthUserController extends Controller
{
    public function __construct() {
      $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
    	$credentials = $request->only('email', 'password'); 
 
      $guard = Auth::guard('api');    
      if (! $token = $guard->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

     public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

      public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

     public function refresh() {
        return $this->respondWithToken($this->guard()->refresh());
    }

     public function userProfile() {
        return response()->json($this->guard()->user());
    }

     protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
