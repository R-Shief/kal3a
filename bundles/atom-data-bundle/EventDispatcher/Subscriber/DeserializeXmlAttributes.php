<?php

namespace Bangpound\Atom\DataBundle\EventDispatcher\Subscriber;

use JMS\Serializer\EventDispatcher\Event;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;

/**
 * Class XmlNamespaceHandler.
 */
class DeserializeXmlAttributes implements EventSubscriberInterface
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
        /** @var \SimpleXMLElement $data */
        $data = $event->getData();
        if (is_subclass_of($type['name'], 'Bangpound\Atom\DataBundle\Model\CommonAttributes')) {
            $namespaces = $data->getNamespaces(true);
            foreach ($namespaces as $prefix => $namespace) {
                foreach ($data->attributes($namespace) as $key => $value) {
                    $data->addAttribute($key, $value, null);
                }
            }
        }
    }
}
