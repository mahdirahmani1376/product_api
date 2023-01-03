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

    public function verify(Request $request,$token)
    {
        $user = auth()->user();
        if (
            ! User::where('email_verified_token',$token)->first()
            && is_null($user->email_verified_at)
            && ! User::where('email_verified_token_expire_time','<',now())->first()
        ){
            return CustomResponse::resource($user,'email has not been verified');
        }

        $user->email_verified_at = now();
        return CustomResponse::resource($user,'email has been verified');
    }

    public function resend(Request $request)
    {
        $user = auth()->user();

        if(is_null($user->email_verified_at)){
            Mail::to($user->email)->send(new UserVerificationEmail($user));
        }

    }


}
