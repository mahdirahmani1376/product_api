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
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register(UserRegisterRequest $request){
        $RequestValidated = $request->validated();

        $UserCheck = User::where('email',$RequestValidated['email'])->first();
        if ($UserCheck){
            return CustomResponse::resource([],'the user already exists',false,403,[]);
        }

        $user = User::create([
            'name' => $RequestValidated['name'],
            'email' => $RequestValidated['email'],
            'password' => $RequestValidated['password'],
        ]);

        return CustomResponse::resource($user,'user successfully created');

    }

    public function login(UserLoginRequest $request){

        $credentials = $request->only('email','password');

        if (!$token = Auth::attempt($credentials)) {
            return CustomResponse::resource([], 'invalid credentials', false,403, []);
        }


        $data = $this->respondWithToken($token);

        return CustomResponse::resource($data,'user successfully logged in');

    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return CustomResponse::resource($this->guard()->user(),'user successfully logged in');
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        return CustomResponse::resource([],'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $data =  $this->respondWithToken($this->guard()->refresh());
        return CustomResponse::resource($data,'Successfully logged out');
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) : array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60 * 60
        ];
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}

