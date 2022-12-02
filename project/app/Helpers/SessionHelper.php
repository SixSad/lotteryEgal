<?php

namespace App\Helpers;

use Egal\Core\Session\Session;

class SessionHelper
{
    public static function getId(): int
    {
        return Session::getUserServiceToken()->getAuthInformation()['id'];
    }

    public static function getRole(): string
    {
        return Session::getUserServiceToken()->getRoles()[0];
    }

}
