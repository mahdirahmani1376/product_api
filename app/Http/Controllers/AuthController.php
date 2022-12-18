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

            $userInfo = ['name' => $user->name, 'token' => $user->createToken('access')->plainTextToken];
            return UserResource::collection($userInfo);
        }
        else{
            return 'user with name ' . $request->name . ' allready exists';
        }

    }

    public function login(UserValidationRequest $request){
        $request->validated();
        if (Auth::attempt($request->only(['email', 'password']))){
            $user = User::where(['email' => $request->email])->get()->first();
            return [
                'name' => $user->name,
                'token' => $user->createToken('access')->plainTextToken,
//                'errot' => ValidationException::withMessages(),
            ];
        }
        else{
            throw new Exception();
        }
    }
}
