<?php

namespace AppBundle\Stream;

use AppBundle\Loader\LoaderHelper;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

class RequestFactory
{
    const FILTER_METHOD = 'POST';
    const FILTER_URL = 'statuses/filter.json';

    const SAMPLE_METHOD = 'GET';
    const SAMPLE_URL = 'statuses/sample.json';

    /**
     * @var array
     */
    private $options;

    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * @param $params
     *
     * @return RequestInterface
     */
    public function filter(array $params): RequestInterface
    {
        // @todo At least one predicate parameter (follow, locations, or track)
        //   must be specified. The default access level allows up to 400 track
        //   keywords, 5,000 follow user IDs and 25 0.1-360 degree location boxes.
        $body = http_build_query(array_filter($params) + $this->options, '', '&');
        return new Request(self::FILTER_METHOD, self::FILTER_URL, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ], $body);
    }

    /**
     * @param array $params
     *
     * @return RequestInterface
     */
    public function sample(array $params): RequestInterface
    {
        $uri = new Uri(self::SAMPLE_URL);
        $value = array_filter($params) + $this->options;
        $query = http_build_query($value, null, '&', PHP_QUERY_RFC3986);
        $uri = $uri->withQuery($query);
        return new Request(self::SAMPLE_METHOD, $uri);
    }

    /**
     * @param $config
     *
     * @return RequestInterface
     * @throws \RuntimeException
     */
    public function fromStreamConfig($config): RequestInterface
    {
        switch ($config['type']) {
            case 'filter':
                $params = LoaderHelper::makeQueryParams($config['parameters']['track'], $config['parameters']['follow'], $config['parameters']['locations']);

                return $this->filter($params);
            case 'sample':
                $params = $config['parameters'];

                return $this->sample($params);
        }
        throw new \RuntimeException('Unsupported type');
    }
}
