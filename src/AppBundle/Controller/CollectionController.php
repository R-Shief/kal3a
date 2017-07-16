<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StreamParameters;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CollectionController.
 *
 * @Sensio\Route("/api")
 */
class CollectionController extends Controller
{
    /**
     * @Sensio\Method("GET")
     * @Sensio\Route("/hashtag")
     * @Nelmio\ApiDoc(deprecated=true)
     * @FOSRest\View(serializerGroups={"default"})
     *
     * @return Response
     *
     * @throws \LogicException
     */
    public function hashtagAction()
    {
        $em = $this->getDoctrine();

        $entities = $em->getRepository('AppBundle:StreamParameters')->findAll();

        $output = array_merge(...array_map(function (StreamParameters $entity) {
            return $entity->getTrack();
        }, $entities));

        return $output;
    }
}
