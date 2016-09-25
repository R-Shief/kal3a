<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\PersonType as BasePersonType;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class PersonType.
 *
 * @ES\Object
 */
class PersonType extends BasePersonType
{
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @var string (xs:string)
     *
     * @ES\Property(type="string")
     */
    protected $name;

    /**
     * @var string (atom:uriType)
     *
     * @ES\Property(type="string")
     */
    protected $uri;

    /**
     * @var string (atom:emailType)
     *
     * @ES\Property(type="string")
     */
    protected $email;
}
