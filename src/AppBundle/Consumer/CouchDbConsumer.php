<?php

namespace AppBundle\Consumer;

use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\HTTP\HTTPException;
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
    private $atomEntryClass;

    /**
     * @param CouchDBClient $client
     * @param string        $atomEntryClass
     */
    public function __construct(CouchDBClient $client, $atomEntryClass)
    {
        $this->client = $client;
        $this->atomEntryClass = $atomEntryClass;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(AMQPMessage $msg)
    {
        $data = $this->serializer->deserialize($msg->body, $this->atomEntryClass, 'json');
        $data = $this->serializer->normalize($data, 'json');
        $data = self::filter($data);

        try {
            $result = $this->client->postDocument($data);
            $this->logger->info('created new document', array_combine(['id', 'rev'], $result));

            return ConsumerInterface::MSG_ACK;
        } catch (HTTPException $e) {
            $this->logger->error($e->getMessage());

            return ConsumerInterface::MSG_REJECT_REQUEUE;
        }
    }

    private static function filter($data)
    {
        // If the data is an array, call this function on the array's values
        // before filtering empty arrays and nulls.
        if (is_array($data)) {
            $data = array_map('self::filter', $data);

            return array_filter($data, function ($value) {
                // array_filter() would ordinarily remove any value that
                // converts to a boolean false, so this callback strictly
                // removes null and empty array to preserve actual false,
                // zero and empty strings.
                return !(null === $value || [] === $value);
            });
        } else {
            return $data;
        }
    }
}
