<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;
use App\Utilities\CustomResponse;

class AuthController extends Controller
{
    public function register(UserValidationRequest $request){
        $request->validated();

        $user_check = User::where('name',$request->name)->get()->first();
        if ($user_check == null){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $data = ['name' => $user->name, 'token' => $user->createToken('access')->plainTextToken];
            return CustomResponse::resource($data,[],0,'user successfully created',true);

        }
        else{
            return CustomResponse::resource([],[],404,'credentials are incorrect',false);
        }

    }

    public function login(UserValidationRequest $request){
        $request->validated();
        if (Auth::attempt($request->only(['email', 'password']))){
            $user = User::where(['email' => $request->email])->get()->first();
            $data =  [
                'name' => $user->name,
                'token' => $user->createToken('access')->plainTextToken,
            ];
            return CustomResponse::resource($data,[],0,'user successfully logged in',true);
        }
        else{
            return CustomResponse::resource([],[],404,'credentials are incorrect',false);
        }
    }
}
