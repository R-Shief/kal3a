<?php

namespace Rshief\PubsubBundle\Guzzle\Plugin;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AcceptJson implements EventSubscriberInterface {

    public static function getSubscribedEvents()
    {
        return array('request.before_send' => 'onBeforeSend');
    }

    public function onBeforeSend(Event $event)
    {
        /* @var $request Guzzle\Http\Request */
        $event['request']->setHeader('Accept', 'application/json');
    }
}