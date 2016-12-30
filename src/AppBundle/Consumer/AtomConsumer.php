<?php

namespace AppBundle\Consumer;

use AppBundle\TweetTransformerToAtom;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\SerializerInterface;

class AtomConsumer implements ConsumerInterface
{
    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * @var TweetTransformerToAtom
     */
    private $transformer;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(ProducerInterface $producer, SerializerInterface $serializer)
    {
        $this->producer = $producer;
        $this->transformer = new TweetTransformerToAtom();

        $this->serializer = $serializer;
    }

    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        $data = \GuzzleHttp\json_decode($msg->getBody(), true);
        $data = $this->transformer->transformTweet($data);

        $newMsg = $this->serializer->serialize($data, 'json');
        $this->producer->publish($newMsg, '', ['content_type' => 'application/json']);

        return ConsumerInterface::MSG_ACK;
    }
}
