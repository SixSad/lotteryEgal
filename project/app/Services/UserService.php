<?php

namespace App\Services;

use App\Models\User;
use Egal\Auth\Tokens\UserMasterRefreshToken;
use Egal\Auth\Tokens\UserServiceToken;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public static function authenticate(string $email, string $password): bool
    {
        /** @var User $user */
        $user = self::getUserByEmail($email);

        return password_verify($password, $user?->getAttribute('password'));
    }

    public static function setTokens(int|string $authIdentifier, array $authInformation): array
    {
        $umrt = new UserMasterRefreshToken();
        $umrt->setSigningKey(config('app.service_key'));
        $umrt->setAuthIdentification($authIdentifier);

        $serviceName = (config('app.service_name'));
        $serviceKey = (config('app.service_key'));

        $ust = new UserServiceToken();
        $ust->setSigningKey($serviceKey);
        $ust->setAuthInformation($authInformation);
        $ust->setTargetServiceName($serviceName);

        return [
            'token' => $ust->generateJWT(),
            'refresh_token' => $umrt->generateJWT()
        ];
    }

    public static function checkRefreshToken(string $refreshToken): UserMasterRefreshToken
    {
        $oldUmrt = UserMasterRefreshToken::fromJWT($refreshToken, config('app.service_key'));
        $oldUmrt->isAliveOrFail();
        return $oldUmrt;
    }

    public static function getUserByEmail(string $email): Model|null
    {
        return User::query()->where('email', $email)->first();
    }

}
