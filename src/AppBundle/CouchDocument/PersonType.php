<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\PersonTypeInterface;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use AppBundle\Annotations as App;

/**
 * Class PersonType.
 */
class PersonType extends CommonAttributes implements PersonTypeInterface
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $uri;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $email;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name = null)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri = null)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email = null)
    {
        $this->email = $email;
    }
}
