<?php

namespace Rshief\TwitterMinerBundle\Subscriber;

use Bangpound\PhirehoseBundle\Event\StreamMessageEvent;
use Bangpound\PhirehoseBundle\PhirehoseEvents;
use Doctrine\DBAL\Connection;
use Rshief\TwitterMinerBundle\Logger\DBALHandler;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class StreamLoggerSubscriber
 * @package Rshief\TwitterMinerBundle\Subscriber
 */
class StreamLoggerSubscriber implements EventSubscriberInterface
{
    private $logger;
    private $connection;

    /**
     * @param Logger $logger
     * @param Connection $connection
     */
    public function __construct(Logger $logger, Connection $connection)
    {
        $this->logger = $logger;
        $this->connection = $connection;
        $this->logger->pushHandler(new DBALHandler($this->connection, Logger::DEBUG, false));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            PhirehoseEvents::DELETE => 'onDelete',
            PhirehoseEvents::SCRUB_GEO => 'onScrubGeo',
            PhirehoseEvents::LIMIT => 'onLimit',
            PhirehoseEvents::STATUS_WITHHELD => 'onStatusWithheld',
            PhirehoseEvents::USER_WITHHELD => 'onUserWithheld',
            PhirehoseEvents::DISCONNECT => 'onDisconnect',
            PhirehoseEvents::WARNING => 'onWarning',
        );
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onDelete(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('delete', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onScrubGeo(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('scrub_geo', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onLimit(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $message = sprintf('Stream has matched more Tweets than its current rate limit allows to be delivered. %d undelivered Tweets since the connection was opened.', $context['track']);
        $this->logger->addInfo($message, $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onStatusWithheld(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('status_withheld', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onUserWithheld(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('user_withheld', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onDisconnect(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('disconnect', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onWarning(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('warning', $context);
    }
}
