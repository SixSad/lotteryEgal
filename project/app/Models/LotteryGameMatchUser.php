<?php

namespace App\Models;

use App\Events\LotteryGameMatchUserCreatingEvent;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id                        {@property-type field}  {@primary-key}
 * @property int $user_id                   {@property-type field}  {@validation-rules required|type:integer|exists:users,id|owner}
 * @property int $lottery_game_match_id     {@property-type field}  {@validation-rules required|type:integer|exists:lottery_game_matches,id}
 * @property Carbon $created_at             {@property-type field}
 * @property Carbon $updated_at             {@property-type field}
 *
 * @action create {@statuses-access logged} {@roles-access user|admin}
 */
class LotteryGameMatchUser extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lottery_game_match_id'
    ];

    protected $dispatchesEvents = [
        'creating' => LotteryGameMatchUserCreatingEvent::class
    ];

}
