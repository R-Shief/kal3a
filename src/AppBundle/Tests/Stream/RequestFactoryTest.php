<?php

namespace AppBundle\Stream;

use Psr\Http\Message\RequestInterface;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $rf = new RequestFactory([]);

        $request = $rf->filter(['track' => 'keyword']);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertContains('keyword', $request->getBody()->__toString());
        $this->assertArraySubset(['Content-Type' => ['application/x-www-form-urlencoded']], $request->getHeaders());
    }

    public function testSample()
    {
        $rf = new RequestFactory([]);

        $request = $rf->sample([]);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertContains('sample', $request->getUri()->__toString());
    }
}
