<?php

namespace Rshief\PubsubBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\FeedType;

/**
 * Class AtomFeed
 * @package Rshief\PubsubBundle\CouchDocument
 */
class AtomFeed extends FeedType {

    /**
     * @var AtomEntry (atom:entryType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $entries;
}