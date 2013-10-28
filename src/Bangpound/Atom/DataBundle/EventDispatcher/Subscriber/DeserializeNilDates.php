<?php

namespace Bangpound\Atom\DataBundle\EventDispatcher\Subscriber;

use JMS\Serializer\EventDispatcher\Event;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;

/**
 * Class DeserializeNilDates
 * @package Bangpound\Atom\DataBundle\EventDispatcher\Subscriber
 */
class DeserializeNilDates implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.pre_deserialize', 'method' => 'onPreDeserialize'),
        );
    }

    /**
     * @param PreDeserializeEvent $event
     */
    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        $type = $event->getType();
        if ($type['name'] == 'Bangpound\Atom\DataBundle\CouchDocument\EntryType') {
            $data = $event->getData();
            if (empty($data->published)) {
                $data->published->addAttribute('nil', 'true');
            }
            if (empty($data->updated)) {
                $data->updated->addAttribute('nil', 'true');
            }
        }
    }
}
