<?php

namespace App\Exceptions;

use Exception;

class InvalidUserModeException extends Exception
{
    protected $message = "Only single user supported for now!";
}
