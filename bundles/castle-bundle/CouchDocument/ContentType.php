<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\ContentType as BaseContentType;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class ContentType.
 *
 * @ES\Object
 */
class ContentType extends BaseContentType
{
    /**
     * @var string (xs:string)
     * @ES\Property(type="string")
     */
    protected $type = 'text';

    /**
     * @var string (xs:anyURI)
     * @ES\Property(type="string")
     */
    protected $src;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    protected $content;
}
