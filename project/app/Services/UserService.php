<?php

namespace App\Services;

use App\Models\User;
use Egal\Auth\Tokens\UserMasterRefreshToken;
use Egal\Auth\Tokens\UserServiceToken;
use Egal\AuthServiceDependencies\Exceptions\UserNotIdentifiedException;
use Exception;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class UserService
{
    /**
     * @throws Exception
     */
    public static function checkPassword(string $email, string $password): Model
    {
        $user = User::query()->where('email', $email)->first();

        if (!$user || !password_verify($password, $user->getAttribute('password'))) {
            throw new Exception('Incorrect Email or password!', 403);
        }

        return $user;

    }

    public static function setTokens(User $user): array
    {
        $umrt = new UserMasterRefreshToken();
        $umrt->setSigningKey(config('app.service_key'));
        $umrt->setAuthIdentification($user->getAuthIdentifier());

        $serviceName = (config('app.service_name'));
        $serviceKey = (config('app.service_key'));

        $ust = new UserServiceToken();
        $ust->setSigningKey($serviceKey);
        $ust->setAuthInformation($user->generateAuthInformation());
        $ust->setTargetServiceName($serviceName);

        return [
            'token' => $ust->generateJWT(),
            'refresh_token' => $umrt->generateJWT()
        ];
    }

}
