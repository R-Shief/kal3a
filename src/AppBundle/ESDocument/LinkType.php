<?php

namespace AppBundle\ESDocument;

use Bangpound\Atom\Model\LinkType as BaseLinkType;
use ONGR\ElasticsearchBundle\Annotation as ES;

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
     */
    protected $href;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $rel;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $type;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    protected $hreflang;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $title;

    /**
     * @var int
     * @ES\Property(type="integer")
     */
    protected $length;
}
