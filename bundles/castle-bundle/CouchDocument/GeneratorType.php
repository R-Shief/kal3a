<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\GeneratorType as BaseGeneratorType;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class GeneratorType.
 *
 * @ES\Object
 */
class GeneratorType extends BaseGeneratorType
{
    /**
     * @var
     */
    protected $uri;

    /**
     * @var
     */
    protected $version;

    /**
     * @var
     */
    protected $generator;
}
