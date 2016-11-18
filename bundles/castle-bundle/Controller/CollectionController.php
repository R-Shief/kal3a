<?php

namespace Bangpound\Bundle\CastleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CollectionController.
 */
class CollectionController extends Controller
{
    /**
     * @Route("/hashtag")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function hashtagAction()
    {
        $em = $this->getDoctrine();

        $entities = $em->getRepository('AppBundle:StreamParameters')->findAll();

        $output = array();
        foreach ($entities as $entity) {
            $output[] = (string) $entity;
        }

        return new JsonResponse($output);
    }
}
