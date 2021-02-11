<?php

namespace App\Exceptions;

use App\Exceptions\Custom\GenericException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class WebExceptionHandler extends Handler
{
    protected $customExceptions = [
        \App\Exceptions\Custom\CreateModelFailedException::class => [
            QueryException::class
        ]  
    ];
    
    /**
     * @param Throwable $exception
     * @return Throwable|null
     */
    private function getCustomException(Throwable $exception)
    {
        $throwable = null;
        
        foreach($this->customExceptions as $customException => $exceptionsToCatch)
        {
            if ($exception instanceof $customException) {
                $throwable = $exception;
            }
        }
        
        return $throwable;
    }
    
    
    /**
     * @param Throwable $exception
     * @return int|string|null
     */
    private function getCaughtException(Throwable $exception)
    {
        $exceptionClass = null;
        
        foreach($this->customExceptions as $customException => $exceptionsToCatch)
        {
            foreach ($exceptionsToCatch as $toCatchException)
            {
                if ($exception instanceof $toCatchException) {
                    $exceptionClass = $customException;
                }
            }
        }
        
        return $exceptionClass;
    }
    
    
    
    public function handleWebException($request, Throwable $exception)
    {
        if (config('app.debug') == false)
        {
            // Check if this is a custom exception
            $customException = $this->getCustomException($exception);
            
            if (!empty($customException)) {
                // Throw the custom exception
                return $this->getUserFriendlyResponse($customException);
            }
            else {
                // Check if this exception has been specified to be caught
                $caughtException = $this->getCaughtException($exception);
                
                if (!empty($caughtException)) {
                    // Throw A custom exception that was specified
                    return $this->getUserFriendlyResponse(app()->make($caughtException));
                }
                else {
                    // Show generic exception
                    return $this->getUserFriendlyResponse(new GenericException());
                }
            }
        }
        else {
            // Default
            return $this->convertExceptionToResponse($exception);
        }
    }
    
    
    /**
     * @param Throwable $exception
     * @return \Illuminate\Http\RedirectResponse
     */
    private function getUserFriendlyResponse(Throwable $exception)
    {
        return back()->withErrors($exception->getMessage());
    }
    
}