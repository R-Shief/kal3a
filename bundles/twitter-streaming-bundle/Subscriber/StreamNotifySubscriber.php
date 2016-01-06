<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Subscriber;

use Bangpound\PhirehoseBundle\Event\StreamMessageEvent;
use Bangpound\PhirehoseBundle\PhirehoseEvents;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StreamNotifySubscriber implements EventSubscriberInterface
{
    private $producer;
    private $routingKey;

    public function __construct(Producer $producer, $type)
    {
        $this->producer = $producer;
        $this->routingKey = $type;
    }

    public static function getSubscribedEvents()
    {
        return array(
            PhirehoseEvents::TWEET => 'onTweet',
        );
    }

    public function onTweet(StreamMessageEvent $event)
    {
        $this->producer->publish($event->getMessage(), $this->routingKey);
    }
}
