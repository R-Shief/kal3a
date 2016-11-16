<?php
/**
 * Created by IntelliJ IDEA.
 * User: bjd
 * Date: 11/16/16
 * Time: 5:51 AM.
 */

namespace AppBundle\Consumer;

use Bangpound\Bundle\TwitterStreamingBundle\TweetTransformerToAtom;
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
        $msg = $this->serializer->serialize($data, 'json');
        $this->producer->publish($msg, '', ['content_type' => 'application/json']);

        return ConsumerInterface::MSG_ACK;
    }
}
