<?php

namespace App\Classes;

class APIResponse
{
    
    /**
     * @param $code
     * @return array
     */
    private static function getBaseContent($code)
    {
        if (!is_numeric($code) || $code < 100 || $code > 500) {
            $code = 500;
        }
    
        $package = [
            'status_code' => $code,
            'date_time' => date('Y-m-d H:i:s')
        ];
        
        return $package;
    }
    
    /**
     * @param $code
     * @param $content
     * @param $message
     * @return \Illuminate\Http\JsonResponse|object
     */
    public static function make($code, $content, $message = '')
    {
        $baseContent = self::getBaseContent($code);
        $baseContent['data'] = $content;
        $baseContent['message'] = $message;
        return response()
            ->json($baseContent)
            ->setStatusCode($code);
    }
    
}