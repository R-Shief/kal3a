<?php

namespace AppBundle\ESDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\CommonAttributes as BaseCommonAttributes;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class CommonAttributes.
 */
class CommonAttributes extends BaseCommonAttributes
{
    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $base;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $lang;
}
