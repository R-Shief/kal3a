<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\CategoryType as BaseCategoryType;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class CategoryType.
 */
class CategoryType extends BaseCategoryType
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $term;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $scheme;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $label;
}