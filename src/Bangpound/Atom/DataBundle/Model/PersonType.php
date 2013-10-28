<?php

namespace Bangpound\Atom\DataBundle\Model;

/**
 * PersonType
 *
 * The Atom person construct is defined in section 3.2 of the format spec.
 *
 * @category DTOs
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */
abstract class PersonType extends CommonAttributes
{

    /**
     * @var string (xs:string)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $name;

    /**
     * @var UriType (atom:uriType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $uri;

    /**
     * @var string (atom:emailType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\UriType
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\UriType $uri
     */
    public function setUri($uri)
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
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
