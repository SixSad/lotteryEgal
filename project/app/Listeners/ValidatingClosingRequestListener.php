<?php

namespace App\Listeners;

use App\Exceptions\UnableToUpdateException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;
use Throwable;

class ValidatingClosingRequestListener extends AbstractListener
{
    /**
     * @throws Throwable
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $winnerId = $model->getAttribute('winner_id');

        throw_if($winnerId, UnableToUpdateException::class);

    }

}
