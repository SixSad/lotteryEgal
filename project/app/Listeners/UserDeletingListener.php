<?php

namespace App\Listeners;

use App\Helpers\SessionHelper;
use Egal\Core\Exceptions\NoAccessActionCallException;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class UserDeletingListener extends AbstractListener
{

    /**
     * @throws NoAccessActionCallException
     */
    public function handle(AbstractEvent $event): void
    {
        if ($event->getAttribute('id') !== SessionHelper::getId()) {
            throw new NoAccessActionCallException;
        }
    }

}
