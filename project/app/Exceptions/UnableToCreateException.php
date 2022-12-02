<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UnableToCreateException extends Exception
{
    protected $message = 'Unable to create record';
    protected $code = Response::HTTP_BAD_REQUEST;
}
