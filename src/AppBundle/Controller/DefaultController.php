<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StreamParameters;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Sensio\Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @FOSRest\Route("/api/stream/{streamParameters}", methods={"GET"})
     * @FOSRest\View(serializerGroups={"default"})
     * @Sensio\ParamConverter
     * @param StreamParameters $streamParameters
     * @return StreamParameters
     */
    public function streamAction(StreamParameters $streamParameters)
    {
        return $streamParameters;
    }
}
