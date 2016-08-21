<?php

namespace Star\Icenter\Listeners;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Star\Icenter\Events\LoginEvent;

class EventListener
{
    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Handle the event.
     *
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {
        $this->user->last_login = Carbon::now();
        $this->user->last_ip = \Request::getClientIp();
        $this->user->save();
    }
}
