<?php

namespace App\Exceptions;

use App\Exceptions;
use App\Models\AppLog;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class WebExceptionHandler extends Handler
{
    
    protected $customExceptions = [
        Exceptions\Custom\CreateModelFailedException::class => [
            QueryException::class
        ],
        Exceptions\Custom\HttpNotFoundException::class => [
            NotFoundHttpException::class
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
    
    
    /**
     * @param $request
     * @param Throwable $exception
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handleWebException($request, Throwable $exception)
    {
        if (config('app.debug') == false)
        {
            // Check if this is a custom exception
            $customException = $this->getCustomException($exception);
            
            if (empty($customException)) 
            {
                // Check if this exception has been specified to be caught
                $caughtException = $this->getCaughtException($exception);
    
                if (!empty($caughtException)) {
                    // Throw A custom exception that was specified
                    $customException = app()->make($caughtException);
                }
                else {
                    // Show generic exception
                    $customException = new Exceptions\Custom\GenericException();
                }   
            }
    
            // Log the exception
            $this->logException($request, $customException);
            
            return $this->handleException($customException);
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
    private function handleException(Throwable $exception)
    {
        if (method_exists($exception, 'redirectTo')) {
            return $exception->redirectTo();
        } else {
            return back()->withErrors($exception->getMessage());    
        }
    }
    
    
    /**
     * @param $request
     * @param Throwable $throwable
     */
    private function logException($request, Throwable $throwable)
    {
        AppLog::createLog($request, AppLog::TYPE_EXCEPTION, $throwable->getMessage());
    }
    
}