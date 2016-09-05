<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Subscriber;

use Bangpound\Bundle\TwitterStreamingBundle\Event\StreamMessageEvent;
use Bangpound\Bundle\TwitterStreamingBundle\PhirehoseEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class StreamLoggerSubscriber.
 */
class StreamLoggerSubscriber implements EventSubscriberInterface
{
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
        $this->logger->info('delete', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onScrubGeo(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->info('scrub_geo', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onLimit(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $message = sprintf('Stream has matched more Tweets than its current rate limit allows to be delivered. %d undelivered Tweets since the connection was opened.', $context['track']);
        $this->logger->info($message, $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onStatusWithheld(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->info('status_withheld', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onUserWithheld(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->info('user_withheld', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onDisconnect(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->info('disconnect', $context);
    }

    /**
     * @param StreamMessageEvent $event
     */
    public function onWarning(StreamMessageEvent $event)
    {
        $context = current(json_decode($event->getMessage(), true));
        $this->logger->info('warning', $context);
    }
}
