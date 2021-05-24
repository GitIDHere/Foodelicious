<?php

namespace App\Listeners;

use App\Models\AppLog;
use Illuminate\Log\Events\MessageLogged;

class AppLogListener
{
    /**
     * @var AppLog
     */
    private $appLogger;

    /**
     * Create the event listener.
     * @return void
     */
    public function __construct(AppLog $log)
    {
        $this->appLogger = $log;
    }

    /**
     * Handle the event.
     *
     * @param MessageLogged  $event
     * @return void
     */
    public function handle(MessageLogged $messageLogged)
    {
        $httpReferrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        $ip = \request()->getClientIp();
        $ua = \request()->userAgent();

        $logInfo = [
            'ip' => $ip,
            'user_agent' => $ua,
            'http_referrer' => $httpReferrer,
            'type' => $messageLogged->level,
            'message' => $messageLogged->message,
        ];

        $this->appLogger->create($logInfo);
    }
}
