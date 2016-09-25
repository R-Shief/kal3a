<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\LinkType as BaseLinkType;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class LinkType.
 *
 * @ES\Object
 */
class LinkType extends BaseLinkType
{
    /**
     * @var string (xs:anyURI)
     *
     * @ES\Property(type="string")
     */
    protected $href;

    /**
     * @var string (xs:string)
     *
     * @ES\Property(type="string")
     */
    protected $rel;

    /**
     * @var string (xs:string)
     *
     * @ES\Property(type="string")
     */
    protected $type;

    /**
     * @var string (xs:NMTOKEN)
     */
    protected $hreflang;

    /**
     * @var string (xs:string)
     *
     * @ES\Property(type="string")
     */
    protected $title;

    /**
     * @var int (xs:positiveInteger)
     */
    protected $length;
}
