<?php

namespace Bangpound\Atom\DataBundle\CouchDocument;

use Bangpound\Atom\Model\SourceType as BaseSourceType;

/**
 * Class SourceType.
 */
class SourceType extends BaseSourceType
{
    public function __construct($title)
    {
        $this->setTitle($title);
    }
}
