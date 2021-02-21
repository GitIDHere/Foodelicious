<?php

namespace App\Exceptions\Custom;

use Exception;
use Throwable;

class HttpNotFoundException extends CustomHttpException
{
    public function __construct($message = "Page not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code);
        $this->setRedirectTo(route('404_page'));
    }
    
}
