<?php

namespace Tivit\StreetMarket\Http\Middleware;

use Log;
use Config;
use Closure;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $logPath = base_path(Config::get('log.path'));

        $streamHandler = new StreamHandler($logPath, Logger::INFO);
        $streamHandler->setFormatter(new JsonFormatter());

        $log = new Logger('request_logger');
        $log->pushHandler($streamHandler);

        $log->info('request', [
            'url' => $request->getRequestUri(),
        ]);

        return $next($request);
    }
}
