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
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            ''
        ]);
    }

    public function resend(Request $request)
    {
    }


}
