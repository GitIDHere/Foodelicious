<?php

namespace App\Classes;

use Illuminate\Contracts\Support\MessageProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class AppResponse
{
    /**
     * @param Request $request
     * @param string $message
     * @param array $data
     * @param int $code
     * @param string $path
     * @return \Illuminate\Contracts\Foundation\Application|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function getResponse(Request $request, $data = [], $code = 204, $message = '', $routeName = '/')
    {
        if ($request->wantsJson())
        {
             $responseData = [
                'message' => $message,
                'data' => $data,
                'status' => $code,
                'date_time' => now()->format('Y-m-d H:i:s')
             ];

             return new JsonResponse($responseData, $code);
        }
        else {
            return redirect()->intended($routeName, $code);
        }
    }


    public static function getErrorResponse(Request $request, $errorBag, $code = 422, $redirectTo = null)
    {
        if ($request->wantsJson())
        {
            $responseData = [
                'errors' => $errorBag,
                'status' => $code,
                'date_time' => now()->format('Y-m-d H:i:s')
            ];

            return new JsonResponse($responseData, $code);
        }
        else
        {
            if ($redirectTo instanceof RedirectResponse) {
                return $redirectTo;
            }
            else {
                return back()->withErrors($errorBag);
            }
        }
    }




}
