<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\CategoryType as BaseCategoryType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

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
     * @ODM\Field(type="string")
     */
    protected $term;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $scheme;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $label;
}
