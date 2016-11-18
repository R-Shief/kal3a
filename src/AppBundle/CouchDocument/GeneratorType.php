<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\GeneratorType as BaseGeneratorType;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class GeneratorType.
 */
class GeneratorType extends BaseGeneratorType
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $uri;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $version;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $generator;
}
