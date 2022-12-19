<?php

namespace App\Providers;

use App\Events\LotteryGameMatchClosingEvent;
use App\Events\LotteryGameMatchUserCreatingEvent;
use App\Listeners\CloseMatchTransactionListener;
use App\Listeners\LotteryGameMatchUserTransactionListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        LotteryGameMatchUserCreatingEvent::class => [
            LotteryGameMatchUserTransactionListener::class,
        ],
        LotteryGameMatchClosingEvent::class => [
            CloseMatchTransactionListener::class
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
