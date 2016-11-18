<?php

namespace AppBundle\Security;

use Aws\Signature\AnonymousSignature;
use Aws\Signature\S3SignatureV4;
use Aws\Signature\SignatureV4;

class SignatureProvider
{
    public static function create()
    {
        return function ($version, $service, $region) {
            switch ($version) {
                case 's3v4':
                    return new EucalyptusSignature($service, $region);
                case 'v4':
                    return $service === 's3'
                      ? new S3SignatureV4($service, $region)
                      : new SignatureV4($service, $region);
                case 'anonymous':
                    return new AnonymousSignature();
                default:
                    return null;
            }
        };
    }
}
