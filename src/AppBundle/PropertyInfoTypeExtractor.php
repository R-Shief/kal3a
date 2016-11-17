<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle;

use AppBundle\Annotations\PropertyInfoType;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

/**
 * Extracts data using Doctrine ORM and ODM metadata.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class PropertyInfoTypeExtractor implements PropertyTypeExtractorInterface
{
    /**
     * @var Reader
     */
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    private function makeType(PropertyInfoType $config)
    {
        if ($config->collection) {
            $keyType = $this->makeType($config->collectionKeyType);
            $valueType = $this->makeType($config->collectionValueType);

            return new Type($config->value, $config->nullable, $config->class, $config->collection, $keyType, $valueType);
        } else {
            return new Type($config->value, $config->nullable, $config->class, $config->collection);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTypes($class, $property, array $context = array())
    {
        $r = new \ReflectionClass($class);
        if ($r->hasProperty($property)) {
            $p = $r->getProperty($property);
            /** @var PropertyInfoType $a */
            $a = $this->reader->getPropertyAnnotation($p, PropertyInfoType::class);
            if ($a) {
                return [
                  $this->makeType($a),
                ];
            }
        }
    }
}
