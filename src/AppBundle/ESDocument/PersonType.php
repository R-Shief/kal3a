<?php

namespace AppBundle\ESDocument;

use Bangpound\Atom\Model\PersonType as BasePersonType;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class PersonType.
 *
 * @ES\Object
 */
class PersonType extends BasePersonType
{
    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $uri;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $email;
}
