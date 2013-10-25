<?php

namespace Rshief\TwitterMinerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RshiefTwitterMinerBundle:Default:index.html.twig', array('name' => $name));
    }
}
