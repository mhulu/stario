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
        $now = Carbon::now();
        $ip = \Request::getClientIp();
        $this->user->last_login = $now;
        $this->user->last_ip = $ip;
        $this->user->save();
        $this->user->events()->create([
                'content' => '在'.$ip.'登陆',
                'type' => 'success'
            ]) ;
    }
}
