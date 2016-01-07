<?php

namespace Bangpound\Atom\DataBundle\CouchDocument;

use Bangpound\Atom\Model\EntryType as BaseEntryType;

/**
 * Class EntryType.
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
