<?php

namespace App\Models;

use App\Services\UserService;
use Carbon\Carbon;
use Egal\AuthServiceDependencies\Models\User as BaseUser;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id         {@property-type field} {@primary-key}
 * @property string $first_name {@property-type field} {@validation-rules required|string}
 * @property string $last_name  {@property-type field} {@validation-rules required|string}
 * @property string $email      {@property-type field} {@validation-rules required|email:dns|unique:users}
 * @property string $password   {@property-type field} {@validation-rules required|string}
 * @property bool $is_admin   {@property-type field} {@validation-rules bool}
 * @property int $points     {@property-type field} {@validation-rules integer}
 * @property Carbon $created_at {@property-type field}
 * @property Carbon $updated_at {@property-type field}
 *
 * @action getItem          {@statuses-access logged} {@roles-access user|admin}
 * @action create           {@statuses-access guest}
 * @action login            {@statuses-access guest}
 * @action refreshToken     {@statuses-access guest}
 * @action update           {@statuses-access logged} {@roles-access user|admin}
 * @action delete           {@statuses-access logged} {@roles-access user|admin}
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
     * @throws Exception
     */
    public static function actionLogin(array $attributes): array
    {
        $user = UserService::checkPassword($attributes['email'], $attributes['password']);

        return UserService::setTokens($user);
    }

}
