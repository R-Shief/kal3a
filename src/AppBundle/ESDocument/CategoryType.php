<?php

namespace AppBundle\ESDocument;

use Bangpound\Atom\Model\CategoryType as BaseCategoryType;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class CategoryType.
 *
 * @ES\Object
 */
class CategoryType extends BaseCategoryType
{
    /**
     * @var string
     *
     * @ES\Property(type="string", options={"analyzer"="tag_analyzer"})
     */
    protected $term;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $scheme;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $label;
}
