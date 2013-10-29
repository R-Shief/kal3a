<?php
namespace Rshief\TwitterMinerBundle\Consumer;

use Bangpound\Atom\DataBundle\CouchDocument\CategoryType;
use Bangpound\Atom\DataBundle\CouchDocument\ContentType;
use Bangpound\Atom\DataBundle\CouchDocument\LinkType;
use Bangpound\Atom\DataBundle\CouchDocument\PersonType;
use Bangpound\Atom\DataBundle\CouchDocument\SourceType;
use Bangpound\Atom\DataBundle\CouchDocument\TextType;
use Bangpound\Twitter\DataBundle\Entity\DataRepository;
use Bangpound\Twitter\DataBundle\Entity\Tweet;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\CouchDB\Attachment;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Rshief\PubsubBundle\CouchDocument\AtomEntry;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Sonata\NotificationBundle\Model\Message;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\Utils\BulkUpdater;

/**
 * Class PhirehoseConsumer
 * @package Rshief\TwitterMinerBundle\Consumer
 */
class PhirehoseConsumer extends ContainerAware implements ConsumerInterface
{
    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $objectManager;

    private $serializer;
    private $jsonOptions;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @param \JMS\Serializer\SerializerInterface $serializer
     */
    public function __construct(ObjectManager $objectManager, SerializerInterface $serializer) {
        $this->objectManager = $objectManager;
        $this->serializer = $serializer;
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

        $entry = new AtomEntry();
        $entry->setAttachment('tweet.json', Attachment::createFromBinaryData($message->getValue('tweet'), 'application/json'));

        $title = new TextType();
        $title->setText($data['text']);
        $entry->setTitle($title);

        $content = new ContentType();
        $content->setContent($data['text']);
        $entry->setContent($content);

        $author = new PersonType();
        $author->setName($data['user']['name']);
        $author->setUri($data['user']['url']);
        $entry->addAuthor($author);

        if (isset($data['entities']['hashtags'])) {
            foreach ($data['entities']['hashtags'] as $hashtag) {
                $category = new CategoryType();
                $category->setTerm($hashtag['text']);
                $entry->addCategory($category);
            }
        }

        if (isset($data['entities']['urls'])) {
            foreach ($data['entities']['urls'] as $url) {
                $link = new LinkType();
                $link->setHref($url['expanded_url']);
                $link->setRel('nofollow');
                $entry->addLink($link);
            }
        }

        if (isset($data['entities']['media'])) {
            foreach ($data['entities']['media'] as $media) {
                $link = new LinkType();
                $link->setHref($media['media_url']);
                $link->setRel('enclosure');
                if ($media['type'] == 'photo') {
                    $link->setType('image');
                }
                $link->setType('image');
                $entry->addLink($link);
            }
        }

        $link = new LinkType();
        $link->setHref('http://twitter.com/'.$data['user']['screen_name'].'/status/'. $data['id_str']);
        $link->setRel('canonical');
        $entry->addLink($link);

        $entry->setPublished(\DateTime::createFromFormat('D M j H:i:s P Y', $data['created_at']));

        $source = new SourceType();
        $title = new TextType();
        $title->setText('Twitter');
        $source->setTitle($title);
        $link = new LinkType();
        $link->setHref('https://twitter.com/intent/user?user_id='. $data['user']['id_str']);
        $link->setRel('author');
        $source->addLink($link);
        $entry->setSource($source);

        $this->objectManager->persist($entry);
        $this->objectManager->flush();
        $this->objectManager->clear();
    }
}
