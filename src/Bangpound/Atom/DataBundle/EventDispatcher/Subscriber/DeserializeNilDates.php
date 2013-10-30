<?php

namespace Bangpound\Atom\DataBundle\EventDispatcher\Subscriber;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\Handler\DateHandler;
use JMS\Serializer\EventDispatcher\Event;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use JMS\Serializer\VisitorInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class DeserializeNilDates
 * @package Bangpound\Atom\DataBundle\EventDispatcher\Subscriber
 */
class DeserializeNilDates implements EventSubscriberInterface
{
    private $handler;

    /**
     * @param DateHandler $handler
     */
    public function __construct(DateHandler $handler)
    {
        $this->handler = $handler;
    }

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
     * Bad dates cause fatal errors, and this is the best remedy I've found so far.
     * The date time handler is brought in so that I can trap the exception that
     * happens when feeds have dates like NaN/NaN/NaN NaN:NaN:NaN.
     *
     * @param PreDeserializeEvent $event
     */
    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        $type = $event->getType();
        if ($type['name'] == 'DateTime') {
            /** @var VisitorInterface $visitor */
            $visitor = $event->getVisitor();

            /** @var \SimpleXMLElement $data */
            $data = $event->getData();


            try {
                $this->handler->deserializeDateTimeFromXml($visitor, $data, $type);
            } catch (RuntimeException $e) {
                $attributes = $data->attributes('xsi', true);
                if (!isset($attributes['nil'][0]) || (string) $attributes['nil'][0] ==! 'true') {
                    $data->addAttribute('xsi:nil', 'true', 'http://www.w3.org/2001/XMLSchema-instance');
                }
                $event->setData($data);
            }
        }
    }
}
