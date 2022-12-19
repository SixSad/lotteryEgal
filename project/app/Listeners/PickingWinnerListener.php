<?php

namespace App\Listeners;

use App\Exceptions\UnableToUpdateException;
use App\Models\LotteryGameMatch;
use Exception;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class PickingWinnerListener extends AbstractListener
{
    /**
     * @throws UnableToUpdateException
     */
    public function handle(AbstractEvent $event): void
    {
        /** @var LotteryGameMatch $model */
        $model = $event->getModel();

        try {
            /** @var int $winnerId */
            $winnerId = $model->users()
                ->inRandomOrder()
                ->firstOrFail()
                ->getAttribute('id');

            $model->update(['winner_id' => $winnerId]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnableToUpdateException('Unable to pick a winner');
        }


    }

}
