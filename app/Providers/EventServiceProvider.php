<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Star\Icenter\Events\LoginEvent' => [
            'Star\Icenter\Listeners\LoginEventListener'
        ],
        'Star\Icenter\Events\UpdateUserEvent' => [
            'Star\Icenter\Listeners\UpdateUserListener'
        ],
        'Star\Icenter\Events\UpdateCredentialsEvent' => [
            'Star\Icenter\Listeners\UpdateCredentialsListener'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
