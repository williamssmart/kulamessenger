<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Laravel\Passport\Bridge\AccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedInfo = $request->validate([
            'fname' => 'required|max:20',
            'lname' => 'required|max:20',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'compound' => 'required',
        ]);
        $validatedInfo['password'] = bcrypt($request->password);
         if(DB::table('users')->insert($validatedInfo)){
            $user = User::where('email' ,'=' , $validatedInfo['email'])->get();
            $accessToken = $user[0]->createToken('authToken')->accessToken;
            return response(['user'=>$user, 'access_token'=>$accessToken]);
         }else{
            return response(['user'=>[]]);
         }

    }

    public function login(Request $request){
        $loginInfo = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($loginInfo)){
            return response([
                'message' => 'Invalid login details'
            ]);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
}
