<?php

namespace AppBundle\Consumer;

use AppBundle\BulkCouchDB;
use PhpAmqpLib\Message\AMQPMessage;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

/**
 * Class CouchDbConsumer.
 */
class CouchDbConsumer implements ConsumerInterface
{
    use SerializerAwareTrait;

    private $atomEntryClass;
    private $bulkConsumer;

    /**
     * @param string $atomEntryClass
     * @param BulkCouchDB $bulkConsumer
     */
    public function __construct($atomEntryClass, BulkCouchDB $bulkConsumer)
    {
        $this->atomEntryClass = $atomEntryClass;
        $this->bulkConsumer = $bulkConsumer;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(AMQPMessage $msg)
    {
        $data = $this->serializer->deserialize($msg->body, $this->atomEntryClass, 'json');
        $data = $this->serializer->normalize($data, 'json');
        $data = self::filter($data);

        $this->bulkConsumer->updateDocument($data);
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
