<?php

namespace AppBundle\Guzzle;

use Evenement\EventEmitterTrait;
use GuzzleHttp\TransferStats;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareTrait;

class Emitter
{
    use EventEmitterTrait;
    use LoggerAwareTrait;

    public function onHeaders(ResponseInterface $response)
    {
        $this->logger->debug(sprintf('Headers'), $response->getHeaders());
    }

    public function onStats(TransferStats $stats)
    {
        $this->logger->debug(sprintf('Transfer time: %f seconds', $stats->getTransferTime()), $stats->getHandlerStats());
    }
}
