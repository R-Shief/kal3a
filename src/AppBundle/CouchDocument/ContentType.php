<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations as App;
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
     * @App\PropertyInfoType("string")
     */
    protected $type = 'text';

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $src;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $content;
}
