<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\CategoryType as BaseCategoryType;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class CategoryType.
 *
 * @ES\Object
 */
class CategoryType extends BaseCategoryType
{
    /**
     * @var string (xs:string)
     *
     * @ES\Property(type="string", options={"analyzer"="tag_analyzer"})
     */
    protected $term;

    /**
     * @var string (xs:anyURI)
     *
     * @ES\Property(type="string")
     */
    protected $scheme;

    /**
     * @var string (xs:string)
     *
     * @ES\Property(type="string")
     */
    protected $label;
}
