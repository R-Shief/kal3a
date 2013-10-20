<?php

namespace Bangpound\Atom\DataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BangpoundAtomDataBundle:Default:index.html.twig', array('name' => $name));
    }
}
