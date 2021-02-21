<?php

namespace App\Exceptions;

use App\Exceptions\Custom\CustomHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        $APIExceptionHandler = app()->make(APIExceptionHandler::class);
        $webExceptionHandler = app()->make(WebExceptionHandler::class);
        
        if ($request->wantsJson()) {
            return $APIExceptionHandler->handleApiException($request, $exception);
        } 
        else {
            $customExeption = $webExceptionHandler->handleWebException($request, $exception);
                
            if ($customExeption instanceof CustomHttpException) 
            {
                return redirect($customExeption->getRedirectTo() ?? url()->previous())
                    ->withInput(Arr::except($request->input(), $this->dontFlash))
                    ->withErrors($customExeption->getErrors());   
            }
            else {
                return parent::render($request, $customExeption);
            }
        }
    }
}
