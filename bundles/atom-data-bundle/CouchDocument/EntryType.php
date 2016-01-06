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
     * @var string
     */
    private $identifier;

    /**
     * @return string
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
