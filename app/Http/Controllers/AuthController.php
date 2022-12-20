<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Utilities\CustomResponse;

class AuthController extends Controller
{

    public function register(UserRegisterRequest $request){
        $RequestValidated = $request->validated();

        $UserCheck = User::where('email',$RequestValidated['email'])->first();
        if ($UserCheck){
            return CustomResponse::resource([],[],'the user already exists',false,403);
        }

        $user = User::create([
            'name' => $RequestValidated['name'],
            'email' => $RequestValidated['email'],
            'password' => Hash::make($RequestValidated['password']),
        ]);

        return CustomResponse::resource($user->toArray(),[],'user successfully created',true);

    }

    public function login(UserLoginRequest $request){

        $credentials = $request->validated();

        if (!$token = Auth::attempt($credentials)) {
            return CustomResponse::resource([], [], 'invalid credentials', false,403);
        }

        $data = [
            'name' => Auth::user()->name,
            'token' => $token
        ];

        return CustomResponse::resource($data,[],'user successfully created',true);

}
}
