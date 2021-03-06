<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StreamParameters;
use AppBundle\Repository\StreamParametersRepository;
use FOS\RestBundle\Request\ParamFetcher;
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
     * @var StreamParametersRepository
     */
    protected $repository;

    /**
     * StreamParametersController constructor.
     *
     * @param StreamParametersRepository $repository
     */
    public function __construct(StreamParametersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Nelmio\ApiDoc(description="All stream parameter entities")
     * @FOSRest\View(serializerGroups={"default"})
     * @FOSRest\QueryParam(name="enabled", default=true, requirements="(0|1)", strict=true, description="enabled parameters", allowBlank=true)
     * @param ParamFetcher $paramFetcher
     * @return array
     * @throws \UnexpectedValueException
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        return $this->repository->findBy($paramFetcher->all());
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
