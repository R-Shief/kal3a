<?php

namespace AppBundle\Guzzle;

use GuzzleHttp\Middleware;

class HistoryMiddleware
{
    /**
     * @var array
     */
    private static $container = array();

    public static function history()
    {
        return Middleware::history(self::$container);
    }

    public static function container()
    {
        return self::$container;
    }
}
