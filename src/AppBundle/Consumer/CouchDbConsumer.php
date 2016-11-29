<?php

namespace AppBundle\Consumer;

use Doctrine\CouchDB\CouchDBClient;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

/**
 * Class CouchDbConsumer.
 */
class CouchDbConsumer implements ConsumerInterface, LoggerAwareInterface
{
    use SerializerAwareTrait;
    use LoggerAwareTrait;

    private $client;
    private $jsonOptions;
    private $atomEntryClass;

    /**
     * @param CouchDBClient $client
     * @param string        $atomEntryClass
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
        $data = $this->serializer->deserialize($msg->body, $this->atomEntryClass, 'json');
        $data = $this->serializer->normalize($data, 'json');
        $data = self::filter($data);

        $result = $this->client->postDocument($data);

        return ConsumerInterface::MSG_ACK;
    }

    private static function filter($data)
    {
        return is_array($data) ? array_filter(array_map('self::filter', $data), function ($value) {
            return !(is_null($value) || (is_array($value) && empty($value)));
        }) : $data;
    }
}
