<?php

namespace App\Listeners;

use App\Exceptions\UnableToUpdateException;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class CloseMatchTransactionListener extends AbstractListener
{
    /**
     * @throws UnableToUpdateException
     */
    public function handle(AbstractEvent $event): void
    {
        DB::beginTransaction();
        (new ValidatingClosingRequestListener())->handle($event);
        (new PickingWinnerListener())->handle($event);
        (new ScoringPointsListener())->handle($event);
        DB::commit();
    }

}
