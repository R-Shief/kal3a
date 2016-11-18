<?php

namespace AppBundle\ESDocument;

use Bangpound\Atom\Model\GeneratorType as BaseGeneratorType;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class GeneratorType.
 *
 * @ES\Object
 */
class GeneratorType extends BaseGeneratorType
{
    /**
     * @var string
     * @ES\Property(type="string")
     */
    protected $uri;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    protected $version;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    protected $generator;
}
