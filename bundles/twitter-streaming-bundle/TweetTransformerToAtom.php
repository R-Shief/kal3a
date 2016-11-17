<?php

namespace Bangpound\Bundle\TwitterStreamingBundle;

use AppBundle\CouchDocument\AtomEntry;
use AppBundle\CouchDocument\TextType;

/**
 * Class TweetTransformerToAtom.
 */
class TweetTransformerToAtom
{
    /**
     * {@inheritdoc}
     */
    public function transformTweet($data)
    {
        $created_at = \DateTime::createFromFormat('D M j H:i:s P Y', $data['created_at']);

        $tweet_path = $data['user']['screen_name'].'/status/'.$data['id_str'];
        $id = 'tag:twitter.com,'.$created_at->format('Y-m-d').':/'.$tweet_path;

        /** @var AtomEntry $entry */
        $entry = new AtomEntry();
        $entry->setId($id);

        $title = new TextType($data['text']);
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
                if (!empty($url['expanded_url'])) {
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

        return $entry;
    }
}
