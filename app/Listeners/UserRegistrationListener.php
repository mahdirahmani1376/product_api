<?php

namespace App\Listeners;

use App\Events\UserRegistrationEvent;
use App\Mail\UserVerificationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserRegistrationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegistrationEvent $event)
    {
        Mail::to($event->user->email)->send(new UserVerificationEmail($event->user));

    }
}
