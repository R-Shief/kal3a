<?php

namespace AppBundle\ESDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\ContentType as BaseContentType;
use ONGR\ElasticsearchBundle\Annotation as ES;

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
     * @App\PropertyInfoType("string")
     */
    protected $type = 'text';

    /**
     * @var string
     * @ES\Property(type="string")
     * App\PropertyInfoType("string", nullable=true)
     */
    protected $src;

    /**
     * @var string
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $content;
}
