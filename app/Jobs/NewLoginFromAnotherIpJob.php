<?php

namespace App\Jobs;

use App\Events\UserLoginEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewLoginFromAnotherIpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $ip;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$ip)
    {
        $this->user = $user;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        event(new UserLoginEvent($this->user,$this->ip));
    }
}
