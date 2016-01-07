<?php

namespace Bangpound\Bundle\CastleBundle\Serializer;

use Bangpound\Bundle\CastleBundle\CouchDocument\AtomEntry;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CouchDbNormalizer extends ObjectNormalizer
{
    public function normalize($object, $format = null, array $context = array())
    {
        $data = parent::normalize($object, $format, $context);

        if (isset($data['attachments'])) {
            $data['_attachments'] = $data['attachments'];
            unset($data['attachments']);
        }

        return self::filter($data);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof AtomEntry;
    }

    private static function filter($data)
    {
        return is_array($data) ? array_filter(array_map('self::filter', $data), function ($value) {
            return !(is_null($value) || (is_array($value) && empty($value)));
        }) : $data;
    }
}
