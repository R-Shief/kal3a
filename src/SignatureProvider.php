<?php

class SignatureProvider
{
    public static function create()
    {
        $a = function ($version, $service, $region) {
            switch ($version) {
                case 's3v4':
                    return new EucalyptusSignature($service, $region);
                case 'v4':
                    return $service === 's3'
                      ? new \Aws\Signature\S3SignatureV4($service, $region)
                      : new \Aws\Signature\SignatureV4($service, $region);
                case 'anonymous':
                    return new \Aws\Signature\AnonymousSignature();
                default:
                    return null;
            }
        };
        return $a;
    }
}
