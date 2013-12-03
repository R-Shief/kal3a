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
            ->add('date_start', 'date', array(
                'label' => 'From',
                'attr' => array(
                    'class' => 'form-group',
                ),
            ))
            ->add('date_end', 'date', array(
                'label' => 'To',
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

        foreach (array('date_start', 'date_end') as $key1) {
            foreach (array('year', 'month', 'day') as $key2) {
                $child = $formBuilder->get($key1)->get($key2);
                $type = $child->getType()->getName();
                $options = $child->getOptions();
                $options['attr'] = array('class' => 'form-control', 'style' => 'width:auto');
                $formBuilder->get($key1)->add($key2, $type, $options);
            }
        }

        $form = $formBuilder->getForm();

        return $this->render('BangpoundCastleSearchBundle:Default:search.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
