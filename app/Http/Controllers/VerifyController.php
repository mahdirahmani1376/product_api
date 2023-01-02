<?php

namespace App\Http\Controllers;

use App\Events\UserRegistrationEvent;
use App\Mail\UserVerificationEmail;
use App\Utilities\CustomResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifyController extends Controller
{
    public function notice(User $user)
    {
    }

    public function verify(Request $request)
    {
        $token = $request->token;
        $id = $request->id;
        $user = auth()->user();
        dd(
           $user->email_verified_token_expire_time < now());
        if(
            $id == $user->id && $token == $user->email_verified_token
            && is_null($user->email_verified_at) && $user->email_verified_token_expire_time < now()
        )
        {
            $user->email_verified_at = now();
            $user->save();

            return CustomResponse::resource($user,'email has been verified');
        }

        return CustomResponse::resource($user,'email has not been verified');
    }

    public function resend(Request $request)
    {
        $user = auth()->user();

        if(is_null($user->email_verified_at)){
            Mail::to($user->email)->send(new UserVerificationEmail($user));
        }

    }


}
