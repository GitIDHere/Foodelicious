<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AppLog extends Model
{
    use HasFactory;

    protected $table = 'app_logs';

    protected $fillable = [
        'ip',
        'user_agent',
        'type',
        'http_referrer',
        'message',
    ];

    const TYPE_CUSTOM = 'custom';
    const TYPE_EXCEPTION = 'exception';
    const TYPE_FATAL = 'fatal';
    const TYPE_WARNING = 'warning';

    /**
     * @param Request $request
     * @param $type
     * @param $payload
     */
    public static function createLog($type, $payload, Request $request = null)
    {
        $ip = $ua = $httpReferrer = null;

        if ($request instanceof Request)
        {
            $httpReferrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;

            $ip = $request->getClientIp();
            $ua = $request->userAgent();

            if(empty($httpReferrer)) {
                $httpReferrer = $request->getPathInfo();
            }
        }

        $message = '';

        if ($payload instanceof \Exception)
        {
            $message = json_encode([
                $payload->getTraceAsString(),
                $payload->getLine(),
                $payload->getMessage()
            ]);
        }
        else if (is_array($payload)) {
            $message = json_encode($payload);
        }
        else if (is_string($payload)) {
            $message = $payload;
        }

        self::create([
            'ip' => $ip,
            'user_agent' => $ua,
            'http_referrer' => $httpReferrer,
            'type' => $type,
            'message' => $message,
        ]);
    }

}
