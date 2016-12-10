<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StreamParameters;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Nelmio\ApiDocBundle\Annotation as Nelmio;

/**
 * Class StreamParametersController.
 *
 * @FOSRest\RouteResource("Stream", pluralize=false)
 */
class StreamParametersController implements ClassResourceInterface
{
    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * StreamParametersController constructor.
     *
     * @param ObjectRepository $repository
     */
    public function __construct(ObjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Nelmio\ApiDoc(description="All stream parameter entities")
     * @FOSRest\View(serializerGroups={"default"})
     */
    public function cgetAction()
    {
        return $this->repository->findAll();
    }

    /**
     * @Nelmio\ApiDoc(description="A specific stream parameter entity")
     * @FOSRest\View(serializerGroups={"default"})
     * @Sensio\ParamConverter
     *
     * @param StreamParameters $parameters
     *
     * @return StreamParameters
     */
    public function getAction(StreamParameters $parameters)
    {
        return $parameters;
    }
}
