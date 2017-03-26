<?php

namespace AppBundle\Controller;

use SensioLabs\Consul\Services\Health;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ConsulHealthController
 * @package AppBundle\Controller
 *
 * @Sensio\Route("/health", service="consul_health_controller")
 */
class ConsulHealthController
{
    /**
     * @var Health
     */
    private $health;

    public function __construct(Health $health)
    {
        $this->health = $health;
    }

    /**
     * @Sensio\Route("/node/{node}")
     * @param $node
     * @param Request $request
     * @return Response
     */
    public function node($node, Request $request)
    {
        $result = $this->health->node($node, $request->query->all());
        return new Response($result->getBody(), $result->getStatusCode(), $result->getHeaders());
    }

    /**
     * @Sensio\Route("/checks/{service}")
     * @param $service
     * @param Request $request
     * @return Response
     */
    public function checks($service, Request $request)
    {
        $result = $this->health->checks($service, $request->query->all());
        return new Response($result->getBody(), $result->getStatusCode(), $result->getHeaders());
    }

    /**
     * @Sensio\Route("/service/{service}")
     * @param $service
     * @param Request $request
     * @return Response
     */
    public function service($service, Request $request)
    {
        $result = $this->health->service($service, $request->query->all());
        return new Response($result->getBody(), $result->getStatusCode(), $result->getHeaders());
    }

    /**
     * @Sensio\Route("/state/{state}")
     * @param $state
     * @param Request $request
     * @return Response
     */
    public function state($state, Request $request)
    {
        $result = $this->health->state($state, $request->query->all());
        return new Response($result->getBody(), $result->getStatusCode(), $result->getHeaders());
    }
}
