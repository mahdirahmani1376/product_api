<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Utilities\CustomResponse;

class AuthController extends Controller
{

    public function register(UserValidationRequest $request){
        $request->validated();

        $UserCheck = User::where('email',$request->email)->get()->first();
        if ($UserCheck == null){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $data = ['name' => $user->name];
            return CustomResponse::resource($data,[],200,'user successfully created',true);

        }
        else{
            return CustomResponse::resource([],[],403,'the user already exists',false);
        }

    }

    public function login(UserValidationRequest $request){

        $request->validated();

        $credentials = $request->only('email', 'password');

        if ($token = Auth::attempt($credentials)) {
            $data = [
                'name' => Auth::user()->name,
                'token' => $token
                ];

            return CustomResponse::resource($data,[],200,'user successfully created',true);
        }
        else {

            return CustomResponse::resource([], [], 403, 'invalid credentials', false);
        }
    }


}
