<?php

namespace App\Http\Controllers;

use App\Utilities\CustomResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function notice(User $user)
    {
        return CustomResponse::resource($user, 'your email needs to be verified', false, 403);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return CustomResponse::resource(auth()->user(), 'your email has been verified');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return CustomResponse::resource(auth()->user(), 'Verification link sent!');
    }


}
