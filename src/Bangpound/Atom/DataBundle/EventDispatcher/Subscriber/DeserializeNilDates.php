<?php

namespace Bangpound\Atom\DataBundle\EventDispatcher\Subscriber;

use JMS\Serializer\EventDispatcher\Event;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\ValidatorInterface;

/**
 * Class DeserializeNilDates
 * @package Bangpound\Atom\DataBundle\EventDispatcher\Subscriber
 */
class DeserializeNilDates implements EventSubscriberInterface
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
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
     * @param PreDeserializeEvent $event
     */
    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        $type = $event->getType();
        if ($type['name'] == 'DateTime') {
            /** @var \SimpleXMLElement $data */
            $data = $event->getData();
            $defaultFormat = \DateTime::ISO8601;
            $defaultTimezone = new \DateTimeZone('UTC');
            $timezone = isset($type['params'][1]) ? new \DateTimeZone($type['params'][1]) : $defaultTimezone;
            $format = isset($type['params'][0]) ? $type['params'][0] : $defaultFormat;
            $datetime = \DateTime::createFromFormat($format, (string) $data, $timezone);
            $errors = $this->validator->validateValue($datetime, new DateTime());
            if (count($errors)) {
                $attributes = $data->attributes('xsi', true);
                if (!isset($attributes['nil'][0]) || (string) $attributes['nil'][0] ==! 'true') {
                    $data->addAttribute('xsi:nil', 'true', 'http://www.w3.org/2001/XMLSchema-instance');
                }
                $event->setData($data);
            }
        }
    }
}
