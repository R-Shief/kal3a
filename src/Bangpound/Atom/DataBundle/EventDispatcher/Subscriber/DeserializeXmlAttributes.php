<?php
/**
 * Created by PhpStorm.
 * User: bjd
 * Date: 10/28/13
 * Time: 4:13 AM
 */

namespace Bangpound\Atom\DataBundle\EventDispatcher\Subscriber;

use JMS\Serializer\EventDispatcher\Event;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;

/**
 * Class XmlNamespaceHandler
 * @package Bangpound\Atom\DataBundle\EventDispatcher\Subscriber
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
        $data = $event->getData();
        if (strpos($type['name'], 'Bangpound\Atom\DataBundle') === 0) {
            $namespaces = $data->getNamespaces(true);
            foreach ($namespaces as $prefix => $namespace) {
                foreach ($data->attributes($namespace) as $key => $value) {
                    $data->addAttribute($key, $value, null);
                }
            }
        }
    }
}
