<?php

namespace AppBundle;

use AppBundle\CouchDocument\AtomEntry;
use AppBundle\CouchDocument\CategoryType;
use AppBundle\CouchDocument\ContentType;
use AppBundle\CouchDocument\LinkType;
use AppBundle\CouchDocument\PersonType;
use AppBundle\CouchDocument\SourceType;
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
        $entry = new AtomEntry();

        $title = new TextType($data['text']);
        $entry->setTitle($title);

        $content = new ContentType();
        $content->setContent($data['text']);
        $entry->setContent($content);

        $author = new PersonType();
        $author->setName($data['user']['name']);
        $author->setUri($data['user']['url']);
        $entry->setAuthors([$author]);

        if (isset($data['entities']['hashtags'])) {
            $categories = [];
            foreach ($data['entities']['hashtags'] as $hashtag) {
                $category = new CategoryType();
                $category->setTerm($hashtag['text']);
                $categories[] = $category;
            }
            $entry->setCategories($categories);
        }

        $links = [];
        $links[] = $this->makeLink('https://twitter.com/intent/user?user_id='.$data['user']['id_str'], 'author');

        if (isset($data['entities']['urls'])) {
            foreach ($data['entities']['urls'] as $url) {
                if (!empty($url['expanded_url'])) {
                    $rel = substr_compare($url['expanded_url'], $url['display_url'], -strlen($url['display_url']), strlen($url['display_url'])) === 0 ? 'shortlink' : 'nofollow';
                    $link = $this->makeLink($url['expanded_url'], $rel);
                    $links[] = $link;
                }
            }
        }

        if (isset($data['entities']['media'])) {
            foreach ($data['entities']['media'] as $media) {
                $link = $this->makeLink($media['media_url'], 'enclosure');
                if ($media['type'] === 'photo') {
                    $link->setType('image');
                }
                $links[] = $link;
            }
        }

        $link = $this->makeLink('https://twitter.com/'.$data['user']['screen_name'].'/status/'.$data['id_str'], 'canonical');
        $links[] = $link;

        $link = $this->makeLink(strtr($data['user']['profile_image_url'], ['_normal' => '']), 'author thumbnail');
        $links[] = $link;

        $entry->setLinks($links);

        $created_at = \DateTime::createFromFormat('D M j H:i:s P Y', $data['created_at']);
        $entry->setPublished($created_at);

        $entry->setLang($data['lang']);

        $source = new SourceType();
        $source->setTitle(new TextType('Twitter'));
        $entry->setSource($source);

        $id = $this->generateId($created_at, $data['user']['screen_name'], $data['id_str']);
        $entry->setId($id);

        return $entry;
    }

    /**
     * @param $href
     * @param $rel
     *
     * @return LinkType
     */
    private function makeLink($href, $rel)
    {
        $link = new LinkType();
        $link->setHref($href);
        $link->setRel($rel);

        return $link;
    }

    /**
     * Helper function to generate a URI with a tag scheme.
     *
     * @todo this could be around URI Templates
     *
     * @param \DateTime $created_at
     * @param $creator_name
     * @param $id_str
     *
     * @return string
     */
    private function generateId(\DateTime $created_at, $creator_name, $id_str)
    {
        return 'tag:twitter.com,'.$created_at->format('Y-m-d').':/'.$creator_name.'/status/'.$id_str;
    }
}
