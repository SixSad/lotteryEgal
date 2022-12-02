<?php

namespace App\Listeners;

use App\Exceptions\UnableToCreateException;
use App\Models\LotteryGameMatchUser;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Throwable;

class DuplicationCheckListener extends AbstractListener
{
    /**
     * @throws Throwable
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $record = LotteryGameMatchUser::query()->where([
            'user_id' => $model->getAttribute('user_id'),
            'lottery_game_match_id' => $model->getAttribute('lottery_game_match_id')
        ])->exists();

        throw_if($record, UnableToCreateException::class);

    }
}
