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

        if(
            $id == $user->id && $token == $user->email_verified_token
            && $user->email_verified_at == null && $user->email_verified_token_expire_time < now()
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
        if($user->email_verified_at == null){
            Mail::to($user->email)->send(new UserVerificationEmail($user));
        }
    }


}
