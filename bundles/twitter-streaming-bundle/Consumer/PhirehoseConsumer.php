<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Consumer;

use Bangpound\Atom\DataBundle\CouchDocument\CategoryType;
use Bangpound\Atom\DataBundle\CouchDocument\ContentType;
use Bangpound\Atom\DataBundle\CouchDocument\LinkType;
use Bangpound\Atom\DataBundle\CouchDocument\PersonType;
use Bangpound\Atom\DataBundle\CouchDocument\SourceType;
use Bangpound\Atom\DataBundle\CouchDocument\TextType;
use Bangpound\Bundle\CastleBundle\CouchDocument\AtomEntry;
use Doctrine\CouchDB\Attachment;
use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\HTTP\Client;
use Doctrine\CouchDB\HTTP\HTTPException;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PhirehoseConsumer.
 */
class PhirehoseConsumer implements ConsumerInterface
{
    private $producer;
    private $jsonOptions;
    private $atomEntryClass;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param CouchDBClient       $client
     * @param SerializerInterface $serializer
     * @param string              $atomEntryClass
     */
    public function __construct(ProducerInterface $producer, SerializerInterface $serializer, $atomEntryClass)
    {
        $this->producer = $producer;
        $this->atomEntryClass = $atomEntryClass;
        $this->jsonOptions = (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0', '>=')) ? JSON_BIGINT_AS_STRING : 0;
        $this->serializer = $serializer;
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

        /** @var AtomEntry $entry */
        $entry = $this->serializer->deserialize($msg->body, AtomEntry::class, 'json', $context);

        $created_at = \DateTime::createFromFormat('D M j H:i:s P Y', $data['created_at']);
        $tweet_path = $data['user']['screen_name'].'/status/'.$data['id_str'];

        $id = 'tag:twitter.com,'.$created_at->format('Y-m-d').':/'.$tweet_path;

        /** @var AtomEntry $entry */
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


        $entry->setLang($data['lang']);

        $entry->setExtra('filter_level', $data['filter_level']);


        $entry->setSource(new SourceType('Twitter'));

        try {
            $data = $this->serializer->serialize($entry, 'json');

            $this->producer->publish($data, 'entry', ['content_type' => 'application/json']);

            return ConsumerInterface::MSG_ACK;
        } catch (HTTPException $e) {
            return ConsumerInterface::MSG_REJECT_REQUEUE;
        }
    }
}
