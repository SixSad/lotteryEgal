<?php

namespace App\Listeners;

use App\Exceptions\UnableToCreateException;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CheckGamerCountListener extends AbstractListener
{
    /**
     * @throws UnableToCreateException
     */
    public function handle(AbstractEvent $event): void
    {
        User::query()->sharedLock();
        /** @var LotteryGameMatchUser $model */
        $model = $event->getModel();

        DB::beginTransaction();
        DB::raw('LOCK TABLE lottery_game_match_users EXCLUSIVE');

        /** @var int $lotteryGamerCount */
        $lotteryGamerCount = LotteryGameMatch::query()
            ->findOrFail($model->getAttribute('lottery_game_match_id'))
            ->lotteryGame
            ->getAttribute('gamer_count');

        $lotteryMatchUsers = LotteryGameMatchUser::query()
            ->where('lottery_game_match_id', $model->getAttribute('lottery_game_match_id'))
            ->count();

        DB::commit();

        throw_if(
            $lotteryMatchUsers >= $lotteryGamerCount,
            UnableToCreateException::class,
            'No places'
        );

    }

}
