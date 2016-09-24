<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Consumer;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\CouchDB\CouchDBClient;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

/**
 * Class PhirehoseConsumer
 * @package Bangpound\Bundle\TwitterStreamingBundle\Consumer
 */
class PhirehoseConsumer implements ConsumerInterface, LoggerAwareInterface
{
    use SerializerAwareTrait;
    use LoggerAwareTrait;

    private $client;
    private $jsonOptions;
    private $atomEntryClass;

    /**
     * @param CouchDBClient $client
     * @param string $atomEntryClass
     */
    public function __construct(CouchDBClient $client, $atomEntryClass)
    {
        $this->client = $client;
        $this->atomEntryClass = $atomEntryClass;
        $this->jsonOptions = (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0', '>=')) ? JSON_BIGINT_AS_STRING : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(AMQPMessage $msg)
    {
        $data = json_decode($msg->body, true, 512, $this->jsonOptions);

        $this->client->postDocument($data);

        return ConsumerInterface::MSG_ACK;
    }
}