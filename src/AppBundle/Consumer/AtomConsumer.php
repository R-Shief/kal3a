<?php

namespace AppBundle\Consumer;

use AppBundle\CouchDocument\AtomEntry;
use AppBundle\Entity\StreamParameters;
use AppBundle\Matcher;
use AppBundle\TweetTransformerToAtom;
use Doctrine\Common\Persistence\ObjectRepository;
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

    /**
     * @var Matcher
     */
    private $matcher;

    public function __construct(ProducerInterface $producer, Matcher $matcher, SerializerInterface $serializer)
    {
        $this->producer = $producer;
        $this->transformer = new TweetTransformerToAtom();
        $this->serializer = $serializer;
        $this->matcher = $matcher;
    }

    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        $body = $msg->getBody();
        $data = \GuzzleHttp\json_decode($body, true);
        /** @var AtomEntry $object */
        $object = $this->transformer->transformTweet($data);
        $object->setParameterNames($this->matcher->match($body));

        $newMsg = $this->serializer->serialize($object, 'json');
        $this->producer->publish($newMsg, '', ['content_type' => 'application/json']);

        return ConsumerInterface::MSG_ACK;
    }
}
