<?php

namespace AppBundle\ESDocument;

use Bangpound\Atom\Model\GeneratorType as BaseGeneratorType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class GeneratorType.
 *
 * @ES\Object
 */
class GeneratorType extends BaseGeneratorType
{
    /**
     * @var
     * @ODM\Field(type="string")
     */
    protected $uri;

    /**
     * @var
     * @ODM\Field(type="string")
     */
    protected $version;

    /**
     * @var
     * @ODM\Field(type="string")
     */
    protected $generator;
}
