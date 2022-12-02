<?php

namespace App\Listeners;

use App\Exceptions\UnableToUpdateException;
use Exception;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class PickingWinnerListener extends AbstractListener
{
    /**
     * @throws UnableToUpdateException
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        try {
            $winnerId = $model->users()
                ->inRandomOrder()
                ->firstOrFail()
                ?->getAttribute('id');

            $model->update(['winner_id' => $winnerId]);

        } catch (Exception $e) {

            throw new UnableToUpdateException;
        }

    }

}
