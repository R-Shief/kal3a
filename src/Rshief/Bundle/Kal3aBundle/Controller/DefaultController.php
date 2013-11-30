<?php

namespace Rshief\Bundle\Kal3aBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RshiefKal3aBundle:Default:index.html.twig', array('name' => $name));
    }
}
