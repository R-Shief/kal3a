<?php

namespace AppBundle\Security;

use Aws\Credentials\CredentialsInterface;
use Aws\Signature\SignatureInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7;

class EucalyptusSignature implements SignatureInterface
{
    /**
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $region;

    /**
     * @param string $service Service name to use when signing
     * @param string $region  Region name to use when signing
     */
    public function __construct($service, $region)
    {
        $this->service = $service;
        $this->region = $region;
    }

    /**
     * Signs the specified request with an AWS signing protocol by using the
     * provided AWS account credentials and adding the required headers to the
     * request.
     *
     * @param RequestInterface     $request     Request to sign
     * @param CredentialsInterface $credentials Signing credentials
     *
     * @return RequestInterface Returns the modified request
     */
    public function signRequest(RequestInterface $request, CredentialsInterface $credentials)
    {
        $resource = $request->getUri()->getPath();
        $xamzHeadersToSign = '';

        foreach (['x-amz-acl', 'x-amz-copy-source', 'x-amz-copy-source-range'] as $key) {
            if ($request->hasHeader($key)) {
                $xamzHeadersToSign .= $key.':'.$request->getHeaderLine($key).PHP_EOL;
            }
        }

        $httpDate = (new \DateTime())->format(\DateTime::RFC1123);
        $contentType = $request->getHeaderLine('content-type');
        $contentMD5 = '';

        /** @var string $toSign based on what Eucalyptus hacked s3curl.pl does */
        $toSign = $request->getMethod()."\n$contentMD5\n$contentType\n$httpDate\n$xamzHeadersToSign$resource";
        $signature = hash_hmac('sha1', $toSign, $credentials->getSecretKey(), true);

        return Psr7\modify_request($request, ['set_headers' => [
          'Date' => $httpDate,
          'Authorization' => 'AWS '.$credentials->getAccessKeyId().':'.base64_encode($signature),
        ]]);
    }

    public function presign(RequestInterface $request, CredentialsInterface $credentials, $expires)
    {
        return $request;
    }
}
