<?php

namespace Bangpound\Bundle\CastleSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package Bangpound\Bundle\CastleSearchBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('bangpound_castle_search_result'))
            ->setMethod('GET')
            ->add('queryTerm', 'text')
            ->add('date', 'date')
            ->add('search', 'submit')
            ->getForm();

        return $this->render('BangpoundCastleSearchBundle:Default:search.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
