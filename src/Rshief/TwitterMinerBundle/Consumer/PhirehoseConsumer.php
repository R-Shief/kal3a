<?php
namespace Rshief\TwitterMinerBundle\Consumer;

use Bangpound\Twitter\DataBundle\Entity\DataRepository;
use Bangpound\Twitter\DataBundle\Entity\Tweet;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializerInterface;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\Utils\BulkUpdater;

class PhirehoseConsumer extends ContainerAware implements ConsumerInterface
{
    /**
     *
     * @var CouchDBClient
     */
    private $client;

    /**
     *
     * @var BulkUpdater
     */
    private $bulkUpdater;

    private $jsonOptions;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->setContainer($container);
        $this->client = $this->container->get('doctrine_couchdb.client.twitter_data_connection');
        $this->jsonOptions = (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0', '>=')) ? JSON_BIGINT_AS_STRING : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ConsumerEvent $event)
    {
        /* @var $message Message */
        $message = $event->getMessage();

        $data = json_decode($message->getValue('tweet'), true, 512, $this->jsonOptions);
        try {
            $this->client->putDocument($data, $data['id']);
        } catch (\Exception $e) {
            $extant = $this->client->findDocument($data['id']);
            if (!$extant) {
                throw $e;
            }
        }
    }
}
