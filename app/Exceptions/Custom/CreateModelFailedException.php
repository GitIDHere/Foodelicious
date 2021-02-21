<?php

namespace App\Exceptions\Custom;

class CreateModelFailedException extends CustomHttpException
{
    public function __construct($message = "Failed to create item", $code = 422)
    {
        parent::__construct($message, $code);
    }
}
