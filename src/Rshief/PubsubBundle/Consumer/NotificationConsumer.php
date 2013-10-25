<?php
namespace Rshief\PubsubBundle\Consumer;

use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\Utils\BulkUpdater;
use Rshief\PubsubBundle\JsonXMLElement;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NotificationConsumer extends ContainerAware implements ConsumerInterface
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

    private $batchSize = 100;
    private $cursor = 0;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->setContainer($container);
        $this->client = $this->container->get('doctrine_couchdb.client.feedmanager_connection');
    }

    /**
     * {@inheritdoc}
     */
    public function process(ConsumerEvent $event)
    {
        /* @var $message Message */
        $message = $event->getMessage();

        /* @var $bulkUpdater BulkUpdater */
        $bulkUpdater = $this->client->createBulkUpdater();
        $content = $message->getValue('content');
        $feed = new JsonXMLElement($content);
        $ids = $this->client->getUuids(count($feed->entry));
        $execute = FALSE;
        foreach ($feed->entry as $entry) {
            $execute = TRUE;
            $data = $entry->jsonSerialize();
            $data = array_pop($data);
            $data['_id'] = array_pop($ids);
            $data['_attachments']['entry.xml'] = array(
                'content_type' => 'text/xml',
                'data' => base64_encode($entry->asXML()),
            );
            $bulkUpdater->updateDocument($data);
        }
        if ($execute) {
            $bulkUpdater->execute();
        }
    }
}
