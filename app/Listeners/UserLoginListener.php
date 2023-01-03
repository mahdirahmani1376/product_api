<?php

namespace App\Listeners;

use App\Events\UserLoginEvent;
use App\Mail\UserNewLoginFromAnotherIpMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserLoginListener
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
    public function handle(UserLoginEvent $event)
    {
        Mail::to($event->user->email)->send(new UserNewLoginFromAnotherIpMail($event->user,$event->ip));
    }
}
