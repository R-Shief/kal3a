<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\LinkType as BaseLinkType;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class LinkType.
 */
class LinkType extends BaseLinkType
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $href;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $rel;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $type;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $hreflang;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $title;

    /**
     * @var int
     * @ODM\Field(type="integer")
     */
    protected $length;
}