<?php

namespace Rshief\TwitterMinerBundle\Subscriber;

use Bangpound\PhirehoseBundle\Event\StreamMessageEvent;
use Bangpound\PhirehoseBundle\PhirehoseEvents;
use Sonata\NotificationBundle\Backend\BackendInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StreamNotifySubscriber implements EventSubscriberInterface
{
    private $backend;
    private $type;

    public function __construct(BackendInterface $backend, $type)
    {
        $this->backend = $backend;
        $this->type = $type;
    }

    public static function getSubscribedEvents()
    {
        return array(
            PhirehoseEvents::TWEET => 'onTweet',
        );
    }

    public function onTweet(StreamMessageEvent $event)
    {
        $body = array('tweet' => $event->getMessage());
        $this->backend->createAndPublish($this->type, $body);
    }
}
