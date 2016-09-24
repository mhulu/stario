<?php

namespace Star\Icenter\Events;

use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Star\Icenter\User;

class UpdateUserEvent extends Event
{
    use SerializesModels;
    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
