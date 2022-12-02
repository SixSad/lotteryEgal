<?php

namespace App\Providers;

use App\Events\LotteryGameMatchClosingEvent;
use App\Events\LotteryGameMatchUserCreatingEvent;
use App\Listeners\CheckGamerCountListener;
use App\Listeners\DuplicationCheckListener;
use App\Listeners\PickingWinnerListener;
use App\Listeners\ScoringPointsListener;
use App\Listeners\ValidatingClosingRequestListener;
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
            DuplicationCheckListener::class,
            CheckGamerCountListener::class
        ],
        LotteryGameMatchClosingEvent::class => [
            ValidatingClosingRequestListener::class,
            PickingWinnerListener::class,
            ScoringPointsListener::class
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
