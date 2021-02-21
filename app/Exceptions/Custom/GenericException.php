<?php

namespace App\Exceptions\Custom;

class GenericException extends CustomHttpException
{
    public function __construct($message="Something went wrong. Please try again later.", $code = 500)
    {
        parent::__construct($message,$code);
    }
}