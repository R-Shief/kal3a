<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\LinkType as BaseLinkType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class LinkType.
 *
 * @ES\Object
 */
class LinkType extends BaseLinkType
{
    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $href;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $rel;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $type;

    /**
     * @var string
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $hreflang;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $title;

    /**
     * @var int
     * @ES\Property(type="integer")
     * @ODM\Field(type="integer")
     */
    protected $length;
}
