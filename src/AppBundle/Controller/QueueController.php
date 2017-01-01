<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class QueueController.
 *
 * @Route("/admin/rabbitmq")
 */
class QueueController extends Controller
{
    /**
     * @Route("/{path}", requirements={"path"=".+"})
     */
    public function indexAction($path)
    {
        $client = $this->get('rabbitmq_api_client');

        $response = $client->get($path);
        $parameters = \GuzzleHttp\json_decode($response->getBody(), true);

        return $this->render('AppBundle:Queue:index.html.twig', ['response' => $parameters]);
    }
}
