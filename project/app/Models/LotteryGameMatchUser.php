<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;

/**
 * @property int $id                        {@property-type field}  {@primary-key}
 * @property int $user_id                   {@property-type field}  {@validation-rules required|integer|exists:users,id}
 * @property int $lottery_game_match_id     {@property-type field}  {@validation-rules required|integer|exists:lottery_game_matches,id}
 * @property Carbon $created_at             {@property-type field}
 * @property Carbon $updated_at             {@property-type field}
 *
 * @action create {@statuses-access logged} {@roles-access user|admin}
 */
class LotteryGameMatchUser extends EgalModel
{
    protected $fillable = [
        'user_id',
        'lottery_game_match_id'
    ];

}
