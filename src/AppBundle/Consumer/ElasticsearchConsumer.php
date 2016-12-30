<?php

namespace AppBundle\Consumer;

use AppBundle\BulkElasticsearch;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use ONGR\ElasticsearchBundle\Exception\BulkWithErrorsException;
use ONGR\ElasticsearchBundle\Service\Manager;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Serializer\SerializerAwareTrait;

class ElasticsearchConsumer implements ConsumerInterface
{
    use SerializerAwareTrait;
    use LoggerAwareTrait;

    private $bulkConsumer;
    private $atomEntryClass;

    /**
     * ElasticsearchConsumer constructor.
     *
     * @param Manager $manager
     * @param string  $atomEntryClass
     */
    public function __construct($atomEntryClass, BulkElasticsearch $bulkConsumer)
    {
        $this->bulkConsumer = $bulkConsumer;
        $this->atomEntryClass = $atomEntryClass;
    }

    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        $data = $this->serializer->deserialize($msg->body, $this->atomEntryClass, 'json');

        $this->bulkConsumer->updateDocument($data);
    }
}
