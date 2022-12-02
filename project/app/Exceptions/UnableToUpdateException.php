<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UnableToUpdateException extends Exception
{
    protected $message = 'Unable to update record';
    protected $code = Response::HTTP_BAD_REQUEST;
}
