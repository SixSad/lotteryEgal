<?php

namespace App\Events;

use App\Helpers\LockMode;
use Egal\Model\Model;
use Illuminate\Support\Facades\DB;
use Sixsad\Helpers\AbstractEvent;

class LotteryGameMatchUserCreatingEvent extends AbstractEvent
{
    public function __construct(Model $model)
    {
        parent::__construct($model);

        $lockMode = LockMode::EXCLUSIVE;
        DB::raw("LOCK TABLE {$this->getModelTable()} $lockMode");
    }

    public function getModelTable(): string
    {
        return $this->getModel()->getTable();
    }
}
