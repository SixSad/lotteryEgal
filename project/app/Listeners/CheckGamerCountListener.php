<?php

namespace App\Listeners;

use App\Exceptions\UnableToCreateException;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Throwable;

class CheckGamerCountListener extends AbstractListener
{
    /**
     * @throws Throwable
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        $lotteryGamerCount = LotteryGameMatch::query()
            ->findOrFail($model->getAttribute('lottery_game_match_id'))
            ?->lotteryGame
            ->getAttribute('gamer_count');

        $lotteryUsers = LotteryGameMatchUser::query()
            ->where('lottery_game_match_id', $model->getAttribute('lottery_game_match_id'))
            ->count();

        throw_if($lotteryUsers >= $lotteryGamerCount, UnableToCreateException::class);

    }

}
