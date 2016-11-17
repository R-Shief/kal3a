<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations\PropertyInfoType;
use Bangpound\Atom\Model\ContentType as BaseContentType;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class ContentType.
 */
class ContentType extends BaseContentType
{
    /**
     * @var string
     * @ODM\Field(type="string")
     * @PropertyInfoType("string")
     */
    protected $type = 'text';

    /**
     * @var string
     * @ODM\Field(type="string")
     * @PropertyInfoType("string")
     */
    protected $src;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @PropertyInfoType("string")
     */
    protected $content;
}
