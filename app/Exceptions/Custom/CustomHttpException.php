<?php

namespace App\Exceptions\Custom;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Response;

class CustomHttpException extends \Exception
{
    /**
     * @var Route|null 
     */
    protected $redirectTo = null;
    
    /**
     * @var array 
     */
    protected $errors = [];
    
    
    public function __construct($error, $code)
    {
        parent::__construct(Response::make($error, $code));
        $this->errors[] = $error;
        $this->code = $code;
    }
    
    /**
     * @param $redirectTo
     */
    protected function setRedirectTo($redirectTo)
    {
        $this->redirectTo = $redirectTo;
    }
    
    /**
     * @return Route|null
     */
    public function getRedirectTo()
    {
        return $this->redirectTo;
    }
    
    /**
     * @param $error
     */
    public function setError($error)
    {
        $this->errors[] = $error;
    }
    
    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}