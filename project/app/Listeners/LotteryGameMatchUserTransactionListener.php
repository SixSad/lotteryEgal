<?php

namespace App\Listeners;

use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;
use Sixsad\Helpers\AbstractListener;

class LotteryGameMatchUserTransactionListener extends AbstractListener
{

    public function handle(AbstractEvent $event): void
    {
        DB::beginTransaction();
        (new DuplicationCheckListener())->handle($event);
        (new CheckGamerCountListener())->handle($event);
        DB::commit();
    }

}
