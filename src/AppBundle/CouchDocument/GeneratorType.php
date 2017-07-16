<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\GeneratorTypeInterface;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use AppBundle\Annotations as App;

/**
 * Class GeneratorType.
 */
class GeneratorType extends CommonAttributes implements GeneratorTypeInterface
{
    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $uri;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $version;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $generator;

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
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version = null)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @param string $generator
     */
    public function setGenerator($generator = null)
    {
        $this->generator = $generator;
    }
}
