<?php

namespace AppBundle\RabbitMq;

use AppBundle\Evenement\PluginInterface;
use Evenement\EventEmitterInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class EnqueueTweetPlugin implements PluginInterface
{
    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * @var string
     */
    private $routingKey;

    /**
     * @var array
     */
    private $additionalProperties;

    public function __construct(ProducerInterface $producer, $routingKey = '', array $additionalProperties = array())
    {
        $this->producer = $producer;
        $this->routingKey = $routingKey;
        $this->additionalProperties = $additionalProperties;
    }

    public function attachEvents(EventEmitterInterface $emitter)
    {
        $emitter->on('tweet', function ($data) {
            $data = json_encode($data);
            $this->producer->publish($data, $this->routingKey, $this->additionalProperties);
        });
    }

    /**
     * @param $data
     */
    private function enqueue($data)
    {
    }
}
