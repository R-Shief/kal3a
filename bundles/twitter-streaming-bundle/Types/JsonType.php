<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Types;

use Doctrine\DBAL\Types\JsonArrayType as BaseType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * convert a value into a json string to be stored into the persistency layer
 */
class JsonType extends BaseType
{
    /**
     * @param $value
     * @param  \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            return json_decode($value, true, 512, JSON_BIGINT_AS_STRING);
        } else {
            return json_decode($value, true, 512);
        }
    }
}
