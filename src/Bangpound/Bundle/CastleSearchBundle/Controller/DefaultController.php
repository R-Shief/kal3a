<?php

namespace Bangpound\Bundle\CastleSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package Bangpound\Bundle\CastleSearchBundle\Controller
 */
class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BangpoundCastleSearchBundle:Default:index.html.twig', array('name' => $name));
    }

    public function resultAction()
    {

    }
}
