<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Egal\Model\With\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id                    {@property-type field} {@primary-key}
 * @property int $lottery_game_id       {@property-type field} {@validation-rules required|integer|exists:lottery_games,id}
 * @property Carbon $start_date         {@property-type field} {@validation-rules required|date_format:Y-m-d|after:today}
 * @property Carbon $start_time         {@property-type field} {@validation-rules required|date_format:H:i}
 * @property int $winner_id             {@property-type field} {@validation-rules filled|integer|exists:users,id}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $winner         {@property-type relation}
 * @property Collection $lottery_game   {@property-type relation}
 * @property Collection $game_users     {@property-type relation}
 *
 * @action getItems     {@statuses-access guest|logged}
 * @action create       {@statuses-access logged} {@roles-access admin}
 */
class LotteryGameMatch extends EgalModel
{
    protected $fillable = [
        'lottery_game_id',
        'start_date',
        'start_time',
        'winner_id'
    ];

    public function lotteryGame(): BelongsTo
    {
        return $this->belongsTo(LotteryGame::class);
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    protected function gameUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
