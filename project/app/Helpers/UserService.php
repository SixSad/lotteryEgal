<?php

namespace App\Helpers;

use App\Models\User;
use Egal\Auth\Tokens\UserMasterRefreshToken;
use Egal\Auth\Tokens\UserServiceToken;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class UserService
{
    /**
     * @throws Exception
     */
    public static function checkPassword(string $email, string $password): Model
    {
        $user = User::query()->where('email', $email)->first();

        if (!$user || !password_verify($password, $user->getAttribute('password'))) {
            throw new Exception('Incorrect Email or password!', Response::HTTP_UNAUTHORIZED);
        }

        return $user;

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

}
