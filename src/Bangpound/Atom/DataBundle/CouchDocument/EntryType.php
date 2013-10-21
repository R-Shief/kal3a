<?php
namespace Bangpound\Atom\DataBundle\CouchDocument;

use Bangpound\Atom\DataBundle\Model\EntryType as BaseEntryType;

/**
 * Class EntryType
 * @package Bangpound\Atom\DataBundle\CouchDocument
 */
class EntryType extends BaseEntryType
{
    /**
     * @var IdType (atom:idType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $identifier;

    /**
     * @return \Bangpound\Atom\DataBundle\CouchDocument\IdType
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\CouchDocument\IdType $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
}
