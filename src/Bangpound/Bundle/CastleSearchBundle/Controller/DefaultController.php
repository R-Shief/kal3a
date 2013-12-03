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
        $formBuilder = $this->createFormBuilder(null, array(
            'attr' => array(
                'class' => 'navbar-form navbar-left',
                'role' => 'search',
        )))
            ->setAction($this->generateUrl('bangpound_castle_search_result'))
            ->setMethod('GET')
            ->add('queryTerm', 'search', array(
                'attr' => array(
                    'placeholder' => 'Search',
                    'class' => 'form-control',
                ),
            ))
            ->add('date', 'date', array(
                'attr' => array(
                    'class' => 'form-group',
                ),
            ))
            ->add('search', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-default',
                ),
                'label' => '<i class="glyphicon glyphicon-search"></i>',
            ));

        foreach (array('year', 'month', 'day') as $key) {
            $child = $formBuilder->get('date')->get($key);
            $type = $child->getType()->getName();
            $options = $child->getOptions();
            $options['attr'] = array('class' => 'form-control', 'style' => 'width:auto');
            $formBuilder->get('date')->add($key, $type, $options);
        }

        $form = $formBuilder->getForm();

        return $this->render('BangpoundCastleSearchBundle:Default:search.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
