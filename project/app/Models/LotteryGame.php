<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Egal\Model\With\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id                {@property-type field}  {@primary-key}
 * @property string $name           {@property-type field}  {@validation-rules required|string}
 * @property int $gamer_count       {@property-type field}  {@validation-rules required|integer|min:5|max:100}
 * @property int $reward_points     {@property-type field}  {@validation-rules required|integer|min:10}
 * @property Carbon $created_at     {@property-type field}
 * @property Carbon $updated_at     {@property-type field}
 *
 * @property Collection $lottery_matches    {@property-type relation}
 *
 * @action getItems {@statuses-access guest|logged}
 */
class LotteryGame extends EgalModel
{

    public function lotteryMatches(): HasMany
    {
        return $this->hasMany(LotteryGameMatch::class);
    }
}
