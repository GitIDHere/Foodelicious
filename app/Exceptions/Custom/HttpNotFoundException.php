<?php

namespace App\Exceptions\Custom;

use Exception;
use Throwable;

class HttpNotFoundException extends Exception
{
    public function __construct($message = "Page not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }
    
    public function redirectTo() {
        return redirect()->route('404_page');
    }
}
