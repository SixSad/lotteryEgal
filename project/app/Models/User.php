<?php

namespace App\Models;

use App\Exceptions\UnableToAuthenticateException;
use App\Services\UserService;
use Carbon\Carbon;
use Egal\AuthServiceDependencies\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id            {@property-type field} {@primary-key}   {@validation-rules owner}
 * @property string $first_name {@property-type field} {@validation-rules required|string}
 * @property string $last_name  {@property-type field} {@validation-rules required|string}
 * @property string $email      {@property-type field} {@validation-rules required|email:dns|unique:users}
 * @property string $password   {@property-type field} {@validation-rules required|string}
 * @property bool $is_admin     {@property-type field} {@validation-rules type:boolean}
 * @property int $points        {@property-type field} {@validation-rules nullable|type:integer}
 * @property Carbon $created_at {@property-type field}
 * @property Carbon $updated_at {@property-type field}
 *
 * @property Collection $win_games              {@property-type relation}
 * @property Collection $lottery_game_matches   {@property-type relation}
 *
 * @action getItems         {@statuses-access logged} {@roles-access admin}
 * @action create           {@statuses-access guest}
 * @action update           {@statuses-access logged} {@roles-access user|admin}
 * @action delete           {@statuses-access logged} {@roles-access user|admin}
 * @action login            {@statuses-access guest}
 * @action refreshTokens    {@statuses-access guest}
 */
class User extends BaseUser
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function password(): Attribute
    {
        return Attribute::set(
            fn(string $value): string => password_hash($value, PASSWORD_BCRYPT),
        );
    }

    protected function getPermissions(): array
    {
        return [];
    }

    protected function getRoles(): array
    {
        return $this->getAttribute('is_admin') ? ['admin'] : ['user'];
    }

    /**
     * @param array $attributes
     * @return array
     * @throws UnableToAuthenticateException
     */
    public static function actionLogin(array $attributes): array
    {
        throw_if(
            !UserService::authenticate(
                $attributes['email'],
                $attributes['password']
            ), UnableToAuthenticateException::class
        );
        /** @var User $user */
        $user = UserService::getUserByEmail($attributes['email']);

        return UserService::setTokens($user->getAuthIdentifier(), $user->generateAuthInformation());
    }

    /**
     * @param array $attributes
     * @return array
     */
    public static function actionRefreshTokens(array $attributes): array
    {
        $aliveRefreshToken = UserService::checkRefreshToken($attributes['refresh_token']);

        $user = static::find($aliveRefreshToken->getAuthIdentification());

        return UserService::setTokens($user->getAuthIdentifier(), $user->generateAuthInformation());

    }

    public function winGames(): HasMany
    {
        return $this->hasMany(LotteryGameMatch::class, 'winner_id');
    }

    public function lotteryGameMatches(): BelongsToMany
    {
        return $this->belongsToMany(LotteryGameMatch::class, 'lottery_game_match_users', 'user_id', 'lottery_game_match_id');
    }

}
