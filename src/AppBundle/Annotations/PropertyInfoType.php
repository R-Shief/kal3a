<?php

namespace AppBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class PropertyInfoType.
 *
 * @Annotation()
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class PropertyInfoType extends Annotation
{
    /**
     * @var string
     *
     * @Enum({"int", "float", "string", "bool", "resource", "object", "array", "null", "callable"})
     */
    public $value;

    /**
     * @var bool
     */
    public $nullable = false;

    /**
     * @var string
     */
    public $class = null;

    /**
     * @var bool
     */
    public $collection = false;

    /**
     * @var PropertyInfoType
     */
    public $collectionKeyType = null;

    /**
     * @var PropertyInfoType
     */
    public $collectionValueType = null;
}
