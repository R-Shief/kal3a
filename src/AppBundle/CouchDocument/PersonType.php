<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\PersonType as BasePersonType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

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
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $uri;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $email;
}
