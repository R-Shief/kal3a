<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\TextType as BaseTextType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Bangpound\Atom\Model\Enum;

/**
 * Class TextType.
 *
 * @ES\Object
 */
class TextType extends BaseTextType
{
    /**
     * @var string
     * @ES\Property(type="string")
     */
    protected $type = Enum\TextConstructType::text;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    protected $text;
}
