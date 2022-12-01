<?php

namespace App\Models;

use App\Events\UserDeletingEvent;
use App\Events\UserUpdatingEvent;
use App\Helpers\SessionHelper;
use App\Services\UserService;
use Carbon\Carbon;
use Egal\AuthServiceDependencies\Models\User as BaseUser;
use Egal\Core\Session\Session;
use Egal\Model\With\Collection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id            {@property-type field} {@primary-key}
 * @property string $first_name {@property-type field} {@validation-rules required|string}
 * @property string $last_name  {@property-type field} {@validation-rules required|string}
 * @property string $email      {@property-type field} {@validation-rules required|email:dns|unique:users}
 * @property string $password   {@property-type field} {@validation-rules required|string}
 * @property bool $is_admin     {@property-type field} {@validation-rules bool}
 * @property int $points        {@property-type field} {@validation-rules integer}
 * @property Carbon $created_at {@property-type field}
 * @property Carbon $updated_at {@property-type field}
 *
 * @property Collection $win_games {@property-type relation}
 * @property Collection $user_matches {@property-type relation}
 *
 * @action getItems         {@statuses-access logged} {@roles-access user|admin}
 * @action create           {@statuses-access guest}
 * @action update           {@statuses-access logged} {@roles-access user|admin}
 * @action delete           {@statuses-access logged} {@roles-access user|admin}
 * @action login            {@statuses-access guest}
 * @action refreshTokens    {@statuses-access guest}
 */
class User extends BaseUser
{

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_admin',
        'points'
    ];

    protected $dispatchesEvents = [
        'updating' => UserUpdatingEvent::class,
        'deleting' => UserDeletingEvent::class
    ];

    protected $hidden = [
        'password',
    ];

    public function newQuery()
    {

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() !== 'admin') {
            return parent::newQuery()->where('id', '=', SessionHelper::getId());
        }

        return parent::newQuery();
    }

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

    public static function actionLogin(array $attributes): array
    {
        $user = UserService::checkPassword($attributes['email'], $attributes['password']);

        return UserService::setTokens($user->getAuthIdentifier(), $user->generateAuthInformation());
    }

    public static function actionRefreshTokens(array $attributes): array
    {
        $aliveRefreshToken = UserService::checkRefreshToken($attributes['refresh_token']);

        $user = static::find($aliveRefreshToken->getAuthIdentification());

        return UserService::setTokens($user->getAuthIdentifier(), $user->generateAuthInformation());

    }

    protected function winGames(): HasMany
    {
        return $this->hasMany(LotteryGameMatch::class, 'winner_id');
    }

    protected function userMatches(): BelongsToMany
    {
        return $this->belongsToMany(LotteryGameMatch::class);
    }

}
