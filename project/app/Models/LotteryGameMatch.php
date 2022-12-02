<?php

namespace App\Models;

use App\Events\LotteryGameMatchClosingEvent;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Sixsad\Helpers\MicroserviceValidator;

/**
 * @property int $id                    {@property-type field} {@primary-key}
 * @property int $lottery_game_id       {@property-type field} {@validation-rules required|type:integer|exists:lottery_games,id}
 * @property Carbon $start_date         {@property-type field} {@validation-rules required|date_format:Y-m-d|after:today}
 * @property Carbon $start_time         {@property-type field} {@validation-rules required|date_format:H:i}
 * @property int $winner_id             {@property-type field} {@validation-rules filled|type:integer|exists:users,id}
 * @property Carbon $created_at         {@property-type field}
 * @property Carbon $updated_at         {@property-type field}
 *
 * @property Collection $winner         {@property-type relation}
 * @property Collection $lottery_game   {@property-type relation}
 * @property Collection $users          {@property-type relation}
 *
 * @action getItems     {@statuses-access guest|logged}
 * @action create       {@statuses-access logged} {@roles-access admin}
 * @action closeMatch   {@statuses-access logged} {@roles-access admin}
 */
class LotteryGameMatch extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'lottery_game_id',
        'start_date',
        'start_time',
        'winner_id'
    ];

    public static function actionCloseMatch(array $attributes): array
    {
        MicroserviceValidator::validate($attributes, [
            'id' => 'required|type:integer|exists:lottery_game_matches,id'
        ]);

        $model = static::query()->find($attributes['id']);
        event(new LotteryGameMatchClosingEvent($model));

        return ['message' => "Match completed successfully. WinnerID: {$model->getAttribute('winner_id')}"];
    }

    public function lotteryGame(): BelongsTo
    {
        return $this->belongsTo(LotteryGame::class);
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lottery_game_match_users', 'lottery_game_match_id', 'user_id');
    }

}
