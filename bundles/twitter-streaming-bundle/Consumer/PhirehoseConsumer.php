<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Consumer;

use Bangpound\Atom\DataBundle\CouchDocument\CategoryType;
use Bangpound\Atom\DataBundle\CouchDocument\ContentType;
use Bangpound\Atom\DataBundle\CouchDocument\LinkType;
use Bangpound\Atom\DataBundle\CouchDocument\PersonType;
use Bangpound\Atom\DataBundle\CouchDocument\SourceType;
use Bangpound\Atom\DataBundle\CouchDocument\TextType;
use Doctrine\CouchDB\Attachment;
use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\HTTP\Client;
use Doctrine\CouchDB\HTTP\HTTPException;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PhirehoseConsumer.
 */
class PhirehoseConsumer implements ConsumerInterface, LoggerAwareInterface
{
    private $client;
    private $jsonOptions;
    private $atomEntryClass;

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param CouchDBClient       $client
     * @param SerializerInterface $serializer
     * @param string              $atomEntryClass
     */
    public function __construct(CouchDBClient $client, SerializerInterface $serializer, $atomEntryClass)
    {
        $this->client = $client;
        $this->atomEntryClass = $atomEntryClass;
        $this->jsonOptions = (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0', '>=')) ? JSON_BIGINT_AS_STRING : 0;
        $this->serializer = $serializer;
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(AMQPMessage $msg)
    {
        $context = array(
          'json_decode_associative' => true,
          'json_decode_recursion_depth' => 512,
          'json_decode_options' => $this->jsonOptions,
        );

        $data = $this->serializer->decode($msg->body, 'json', $context);

        $created_at = \DateTime::createFromFormat('D M j H:i:s P Y', $data['created_at']);
        $tweet_path = $data['user']['screen_name'].'/status/'.$data['id_str'];

        $id = 'tag:twitter.com,'.$created_at->format('Y-m-d').':/'.$tweet_path;

        /** @var \Bangpound\Bundle\TwitterStreamingBundle\CouchDocument\AtomEntry $entry */
        $entry = new $this->atomEntryClass();
        $entry->setId($id);
        $entry->setAttachment('original', Attachment::createFromBinaryData($msg->body, 'application/json'));

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

        $link = new LinkType();
        $link->setHref('https://twitter.com/intent/user?user_id='.$data['user']['id_str']);
        $link->setRel('author');
        $entry->addLink($link);

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
                if (substr_compare($url['expanded_url'], $url['display_url'], -strlen($url['display_url']), strlen($url['display_url'])) === 0) {
                    $link->setRel('shortlink');
                } else {
                    $link->setRel('nofollow');
                }
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
        $link->setHref('http://twitter.com/'.$tweet_path);
        $link->setRel('canonical');
        $entry->addLink($link);

        $link = new LinkType();
        $link->setHref(strtr($data['user']['profile_image_url'], ['_normal' => '']));
        $link->setRel('author thumbnail');
        $entry->addLink($link);

        $entry->setPublished($created_at);

        $source = new SourceType();
        $title = new TextType();
        $title->setText('Twitter');
        $source->setTitle($title);
        $entry->setSource($source);

        $entry->setLang($data['lang']);

        $entry->setExtra('filter_level', $data['filter_level']);

        $data = $this->serializer->normalize($entry);
        try {
            $result = $this->client->postDocument($data);

            return ConsumerInterface::MSG_ACK;
        } catch (HTTPException $e) {
            return ConsumerInterface::MSG_REJECT_REQUEUE;
        }
    }
}
