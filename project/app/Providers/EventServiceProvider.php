<?php

namespace App\Providers;

use App\Events\UserDeletingEvent;
use App\Events\UserUpdatingEvent;
use App\Listeners\UserDeletingListener;
use App\Listeners\UserUpdatingListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserDeletingEvent::class => [
            UserDeletingListener::class
        ],
        UserUpdatingEvent::class => [
            UserUpdatingListener::class
        ]
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
