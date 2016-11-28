<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\CommonAttributes as BaseCommonAttributes;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class CommonAttributes.
 */
class CommonAttributes extends BaseCommonAttributes
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $base;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $lang;
}
