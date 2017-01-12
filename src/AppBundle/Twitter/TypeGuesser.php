<?php

namespace AppBundle\Twitter;

/**
 * Class TypeGuesser.
 */
class TypeGuesser
{
    /**
     * @param $data array single Twitter streaming message
     *
     * @return string message type
     */
    public function getEventName(array $data)
    {
        // Twitter public stream messages that decode as objects with only
        // one property are events of that type. Events may also be objects
        // with multiple properties including an `event` property. Other
        // message objects many properties are a standard Tweet payload.
        // @see <https://dev.twitter.com/streaming/overview/messages-types>
        if (isset($data['event'])) {
            $event = count($data) > 1 ? $data['event'] : key($data);
        } else {
            $event = count($data) > 1 ? 'tweet' : key($data);
        }

        return $event;
    }
}
