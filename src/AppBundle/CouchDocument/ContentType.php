<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations\PropertyInfoType;
use Bangpound\Atom\Model\ContentType as BaseContentType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class ContentType.
 *
 * @ES\Object
 */
class ContentType extends BaseContentType
{
    /**
     * @var string
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     * @PropertyInfoType("string")
     */
    protected $type = 'text';

    /**
     * @var string
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     * @PropertyInfoType("string")
     */
    protected $src;

    /**
     * @var string
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     * @PropertyInfoType("string")
     */
    protected $content;
}
