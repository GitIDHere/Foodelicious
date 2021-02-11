<?php

namespace App\Exceptions\Custom;

use Throwable;

class GenericException extends \Exception
{
    public function __construct($message="Something went wrong. Please try again later.", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }
}