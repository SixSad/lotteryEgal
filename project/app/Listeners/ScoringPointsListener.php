<?php

namespace App\Listeners;

use App\Exceptions\UnableToUpdateException;
use Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class ScoringPointsListener extends AbstractListener
{
    /**
     * @throws UnableToUpdateException
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        try {
            $winner = $model->winner()->firstOrFail();
            $lotteryGame = $model->lotteryGame()->firstOrFail();
            $winner->increment('points', $lotteryGame->getAttribute('reward_points'));

        } catch (Exception $e) {

            throw new UnableToUpdateException;
        }
    }

}
