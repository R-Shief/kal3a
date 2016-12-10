<?php

namespace AppBundle\Consumer;

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

    private $manager;
    private $atomEntryClass;

    /**
     * ElasticsearchConsumer constructor.
     *
     * @param Manager $manager
     * @param string  $atomEntryClass
     */
    public function __construct(Manager $manager, $atomEntryClass)
    {
        $this->manager = $manager;
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

        $this->manager->persist($data);
        try {
            $result = $this->manager->commit();
            $this->logger->info('created new documents', $result);

            return ConsumerInterface::MSG_ACK;
        } catch (BulkWithErrorsException $e) {
            $this->logger->error($e->getMessage());

            return ConsumerInterface::MSG_REJECT_REQUEUE;
        }
    }
}
