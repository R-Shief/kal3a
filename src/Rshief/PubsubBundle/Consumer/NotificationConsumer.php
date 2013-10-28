<?php
namespace Rshief\PubsubBundle\Consumer;

use Bangpound\Atom\DataBundle\CouchDocument\SourceType;
use Doctrine\CouchDB\Attachment;
use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\Utils\BulkUpdater;
use Doctrine\ODM\CouchDB\DocumentManager;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\Exception\RuntimeException;
use Rshief\PubsubBundle\JsonXMLElement;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\Serializer\SerializerInterface;

/**
 * Class NotificationConsumer
 * @package Rshief\PubsubBundle\Consumer
 */
class NotificationConsumer implements ConsumerInterface
{
    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $objectManager;

    private $serializer;

    private $batchSize = 100;
    private $cursor = 0;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @param \JMS\Serializer\SerializerInterface $serializer
     */
    public function __construct(ObjectManager $objectManager, SerializerInterface $serializer) {
        $this->objectManager = $objectManager;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ConsumerEvent $event)
    {
        /* @var $message Message */
        $message = $event->getMessage();

        $serializer = $this->serializer;
        $content = $message->getValue('content');
        $xml = new \SimpleXMLElement($content);

        try {
            /** @var \Rshief\PubsubBundle\CouchDocument\AtomFeed $feed */
            $feed = $serializer->deserialize($content, 'Rshief\PubsubBundle\CouchDocument\AtomFeed', 'xml');

            $source = new SourceType();
            $source->setAuthors($feed->getAuthors());
            $source->setBase($feed->getBase());
            $source->setCategories($feed->getCategories());
            $source->setContributors($feed->getContributors());
            $source->setGenerator($feed->getGenerator());
            $source->setIcon($feed->getIcon());
            $source->setLang($feed->getLang());
            $source->setLogo($feed->getLogo());
            $source->setLinks($feed->getLinks());
            $source->setRights($feed->getRights());
            $source->setSubtitle($feed->getSubtitle());
            $source->setTitle($feed->getTitle());
            $source->setUpdated($feed->getUpdated());

            $execute = FALSE;
            /** @var \Rshief\PubsubBundle\CouchDocument\AtomEntry $entry */
            foreach ($feed->getEntries() as $key => $entry) {
                $execute = TRUE;
                if (!$entry->getSource()) {
                    $entry->setSource(clone $source);
                }

                $attachment = Attachment::createFromBinaryData($xml->entry[$key]->asXml(), 'text/xml');
                $entry->setAttachment('entry.xml', $attachment);

                $this->objectManager->persist($entry);
            }
            if ($execute) {
                $this->objectManager->flush();
            }
            $this->objectManager->clear();
        }
        catch (RuntimeException $e) {
            throw $e;
        }
    }
}
