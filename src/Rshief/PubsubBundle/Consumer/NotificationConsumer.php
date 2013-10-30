<?php
namespace Rshief\PubsubBundle\Consumer;

use Bangpound\Atom\DataBundle\CouchDocument\SourceType;
use Doctrine\CouchDB\Attachment;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\Exception\RuntimeException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Sonata\NotificationBundle\Model\Message;
use JMS\Serializer\SerializerInterface;

/**
 * Class NotificationConsumer
 * @package Rshief\PubsubBundle\Consumer
 */
class NotificationConsumer implements ConsumerInterface, LoggerAwareInterface
{
    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $objectManager;

    /**
     * @var \JMS\Serializer\SerializerInterface
     */
    private $serializer;

    private $atomEntryClass;

    /**
     * @var int
     */
    private $batchSize = 100;

    /**
     * @var int
     */
    private $cursor = 0;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @param \JMS\Serializer\SerializerInterface        $serializer
     * @param $atomEntryClass
     */
    public function __construct(ObjectManager $objectManager, SerializerInterface $serializer, $atomEntryClass)
    {
        $this->objectManager = $objectManager;
        $this->serializer = $serializer;
        $this->atomEntryClass = $atomEntryClass;
    }

    /**
     * Sets a logger instance on the object
     *
     * @param  LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
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

        /** @var \Doctrine\Common\Persistence\ObjectRepository $repository */
        $repository = $this->objectManager->getRepository($this->atomEntryClass);

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
                $id = $entry->getId();
                $existing = $repository->findOneBy(['id' => $id]);
                if ($existing) {
                    $this->logger->info(sprintf('Duplicate notification sent for %s - %s', $id, $entry->getTitle()), ['existing' => $existing, 'new' => $entry]);
                    continue;
                }
                $execute = TRUE;
                if (!$entry->getSource()) {
                    $entry->setSource(clone $source);
                }

                $entry->setOriginalData($xml->entry[$key]->asXml(), 'text/xml');

                $this->objectManager->persist($entry);
            }
            if ($execute) {
                $this->objectManager->flush();
            }
            $this->objectManager->clear();
        } catch (RuntimeException $e) {
            throw $e;
        }
    }
}
