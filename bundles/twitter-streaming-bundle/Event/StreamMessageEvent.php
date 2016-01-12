<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class StreamMessageEvent extends Event
{
    protected $message;

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }
}
