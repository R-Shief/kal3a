<?php

/**
 *
 * @author bjd
 */

namespace Rshief\PubsubBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Sputnik\Bundle\PubsubBundle\PubsubEvents;
use Sputnik\Bundle\PubsubBundle\Event\NotificationReceivedEvent;
use Sonata\NotificationBundle\Backend\BackendInterface;

class PubsubNotification implements EventSubscriberInterface {

    private $backend;

    public function __construct(BackendInterface $backend)
    {
        $this->backend = $backend;
    }

    public static function getSubscribedEvents()
    {
        return array(PubsubEvents::NOTIFICATION_RECEIVED => 'onNotificationReceived');
    }

    public function onNotificationReceived(NotificationReceivedEvent $event)
    {
        // create and publish a message
        $this->backend->createAndPublish(
            'pubsub_notification',
             array(
                'topic' => $event->getTopic()->getId(),
                'headers' => (string) $event->getHeaders(),
                'content' => $event->getContent(),
             )
        );
    }
}
