<?php

namespace App\Exceptions\Custom;

use Exception;
use Throwable;

class CreateModelFailedException extends Exception
{
    public function __construct($message="Failed to create item", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }
}
