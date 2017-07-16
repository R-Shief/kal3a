<?php

namespace AppBundle\Guzzle;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\VarDumper\VarDumper;

class RetryMiddleware
{
    /**
     * @var callable
     */
    private $nextHandler;

    public function __construct(callable $nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }

    public function __invoke(RequestInterface $request, array $options)
    {
        $prev = $this->nextHandler;

        foreach (array_reverse(self::retryMiddlewares()) as $fn) {
            $prev = $fn[0]($prev);
        }

        return $prev($request, $options);
    }

    public static function retry()
    {
        return function (callable $handler) {
            return new RetryMiddleware($handler);
        };
    }

    private static function retryMiddlewares()
    {
        return array(
          [Middleware::retry(self::connectExceptionDecider(), self::linearDelay(250, 16000)), 'connect_error'],
          [Middleware::retry(self::httpErrorDecider(), self::exponentialDelay(5000, 320000)), 'http_error'],
          [Middleware::retry(self::rateLimitErrorDecider(), self::exponentialDelay(60000)), 'rate_limit'],
        );
    }

    public static function connectExceptionDecider()
    {
        return function ($retries, Psr7\Request $request, Psr7\Response $response = null, $error = null) {
            return ! (bool) $response || $error instanceof ConnectException;
        };
    }

    public static function rateLimitErrorDecider()
    {
        return function ($retries, Psr7\Request $request, Psr7\Response $response = null, $error = null) {
            return $response && $response->getStatusCode() === 420;
        };
    }

    public static function httpErrorDecider()
    {
        return function ($retries, Psr7\Request $request, Psr7\Response $response = null, $error = null) {
            return $response && $response->getStatusCode() >= 400;
        };
    }

    public static function exponentialDelay($base, $maxDelay = 0)
    {
        return function ($retries) use ($base, $maxDelay) {
            $delay = \GuzzleHttp\RetryMiddleware::exponentialDelay($retries) * $base;

            return $maxDelay ? min($delay, $maxDelay) : $delay;
        };
    }

    public static function linearDelay($base, $maxDelay = 0)
    {
        return function ($retries) use ($base, $maxDelay) {
            $delay = $retries * $base;

            return $maxDelay ? min($delay, $maxDelay) : $delay;
        };
    }
}
