<?php

namespace Rshief\TwitterMinerBundle\Subscriber;

use Bangpound\PhirehoseBundle\Event\StreamMessageEvent;
use Bangpound\PhirehoseBundle\PhirehoseEvents;
use Doctrine\DBAL\Connection;
use Rshief\TwitterMinerBundle\Logger\DBALHandler;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StreamLoggerSubscriber implements EventSubscriberInterface
{
    private $logger;
    private $connection;

    public function __construct(Logger $logger, Connection $connection)
    {
        $this->logger = $logger;
        $this->connection = $connection;
        $this->logger->pushHandler(new DBALHandler($this->connection, Logger::DEBUG, false));
    }

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

    public function onDelete(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('delete', $context);
    }

    public function onScrubGeo(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('scrub_geo', $context);
    }

    public function onLimit(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $message = sprintf('Stream has matched more Tweets than its current rate limit allows to be delivered. %d undelivered Tweets since the connection was opened.', $context['track']);
        $this->logger->addInfo($message, $context);
    }

    public function onStatusWithheld(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('status_withheld', $context);
    }

    public function onUserWithheld(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('user_withheld', $context);
    }

    public function onDisconnect(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('disconnect', $context);
    }

    public function onWarning(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->addInfo('warning', $context);
    }
}
