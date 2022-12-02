<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id                {@property-type field}  {@primary-key}
 * @property string $name           {@property-type field}  {@validation-rules required|string}
 * @property int $gamer_count       {@property-type field}  {@validation-rules required|type:integer|numeric|min:5|max:100}
 * @property int $reward_points     {@property-type field}  {@validation-rules required|type:integer|numeric|min:10|max:1000}
 * @property Carbon $created_at     {@property-type field}
 * @property Carbon $updated_at     {@property-type field}
 *
 * @property Collection $lottery_game_matches    {@property-type relation}
 *
 * @action getItems {@statuses-access guest|logged}
 */
class LotteryGame extends EgalModel
{
    use HasFactory;

    public function lotteryGameMatches(): HasMany
    {
        return $this->hasMany(LotteryGameMatch::class);
    }
}
