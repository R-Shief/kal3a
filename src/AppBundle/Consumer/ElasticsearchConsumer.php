<?php

namespace AppBundle\Consumer;

use AppBundle\ESDocument\AtomEntry;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
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
        $data = $this->serializer->deserialize($msg->body, AtomEntry::class, 'json');

        $this->manager->persist($data);
        $result = $this->manager->commit();

        return ConsumerInterface::MSG_ACK;
    }
}
