<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Stream;

use Bangpound\Bundle\TwitterStreamingBundle\Event\StreamMessageEvent;
use Bangpound\Bundle\TwitterStreamingBundle\PhirehoseEvents;
use OauthPhirehose as OauthPhirehose;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BasicStream extends OauthPhirehose implements LoggerAwareInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var int
     */
    protected $lastMemoryUsage;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function enqueueStatus($status)
    {
        $body = json_decode($status, true, 512, JSON_BIGINT_AS_STRING);
        $eventName = count($body) > 1 ? PhirehoseEvents::TWEET : 'phirehose.'.key($body);
        $event = new StreamMessageEvent(trim($status));
        $this->dispatcher->dispatch($eventName, $event);
    }

    /**
     * {@inheritdoc}
     */
    protected function log($message, $level = 'notice')
    {
        $this->logger->log($level, trim($message));
    }

    /**
     * {@inheritdoc}
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
