<?php

namespace App\Listeners;

use App\Exceptions\UnableToUpdateException;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class ScoringPointsListener extends AbstractListener
{
    /**
     * @throws UnableToUpdateException
     */
    public function handle(AbstractEvent $event): void
    {
        /** @var LotteryGameMatch $model */
        $model = $event->getModel();

        try {
            /** @var User $winner */
            $winner = $model->winner()->firstOrFail();
            /** @var LotteryGame $lotteryGame */
            $lotteryGame = $model->lotteryGame()->firstOrFail();
            $winner->increment('points', $lotteryGame->getAttribute('reward_points'));

        } catch (Exception $e) {
            DB::rollBack();
            throw new UnableToUpdateException('Unable to score points');
        }
    }

}
