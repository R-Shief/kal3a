<?php

namespace Bangpound\Atom\DataBundle\CouchDocument;

use Bangpound\Atom\Model\EntryType as BaseEntryType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * Class EntryType.
 */
class EntryType extends BaseEntryType
{
    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->contributors = new ArrayCollection();
        $this->links = new ArrayCollection();
    }

    /**
     * @var string
     */
    private $identifier;

    /**
     * @return string
     *
     * @Serializer\Groups
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
}
