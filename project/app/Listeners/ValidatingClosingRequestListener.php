<?php

namespace App\Listeners;

use App\Events\LotteryGameMatchClosingEvent;
use App\Exceptions\UnableToUpdateException;
use App\Models\LotteryGameMatch;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class ValidatingClosingRequestListener extends AbstractListener
{
    /**
     * @throws  UnableToUpdateException
     */
    public function handle(AbstractEvent $event): void
    {
        /** @var LotteryGameMatch $model */
        $model = $event->getModel();

        $winnerId = $model->getAttribute('winner_id');

        if ($winnerId) {
            DB::rollBack();
            throw new UnableToUpdateException('The winner has already been chosen');
        }

    }

}
