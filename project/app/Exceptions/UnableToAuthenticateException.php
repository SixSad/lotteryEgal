<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UnableToAuthenticateException extends Exception
{
    protected $message = 'Incorrect Email or password!';
    protected $code = Response::HTTP_UNAUTHORIZED;
}
