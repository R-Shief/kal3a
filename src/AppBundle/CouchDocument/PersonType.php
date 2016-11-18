<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\PersonType as BasePersonType;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class PersonType.
 */
class PersonType extends BasePersonType
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $uri;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $email;
}