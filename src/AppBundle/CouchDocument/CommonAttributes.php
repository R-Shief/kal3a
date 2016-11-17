<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\CommonAttributes as BaseCommonAttributes;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class CommonAttributes.
 */
class CommonAttributes extends BaseCommonAttributes
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $base;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $lang;
}
