<?php

namespace Bangpound\Bundle\CastleSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class DefaultController.
 */
class DefaultController extends Controller
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $data = array(
            'published_upper' => new \DateTime(),
        );
        $lowerDate = new \DateTime();
        $upperDate = new \DateTime();
        $formBuilder = $this->createFormBuilder($data, array(
            'attr' => array(
                'class' => 'form-inline facetview_search_options_container',
                'role' => 'search',
        ), ))
            ->add('queryTerm', 'search', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'attr' => array(
                    'placeholder' => 'Search our Archive | إبحث أرشيف',
                    'class' => 'form-control',
                ),
                'label_attr' => array(
                    'class' => 'control-label sr-only',
                ),
            ))
            ->add('published_lower', 'date', array(
                'months' => array($lowerDate->format('n'), $lowerDate->sub(new \DateInterval('P1M'))->format('n')),
                'years' => array($lowerDate->format('Y'), $lowerDate->sub(new \DateInterval('P1M'))->format('Y')),
                'empty_value' => '',
                'label' => 'From',
                'label_attr' => array(
                    'class' => 'control-label sr-only',
                ),
                'required' => false,
            ))
            ->add('published_upper', 'date', array(
                'months' => array($upperDate->format('n'), $upperDate->sub(new \DateInterval('P1M'))->format('n')),
                'years' => array($upperDate->format('Y'), $upperDate->sub(new \DateInterval('P1M'))->format('Y')),
                'empty_value' => '',
                'label' => 'To',
                'label_attr' => array(
                    'class' => 'control-label sr-only',
                ),
                'required' => false,
            ))
            ->add('search', 'submit', array(
                'label' => '<i class="glyphicon glyphicon-search"></i>',
            ));

        foreach (array('published_lower', 'published_upper') as $key1) {
            foreach (array('year', 'month', 'day') as $key2) {
                $child = $formBuilder->get($key1)->get($key2);
                $type = $child->getType()->getName();
                $options = $child->getOptions();
                $options['attr'] = array('class' => 'form-control', 'style' => 'width:auto');
                $formBuilder->get($key1)->add($key2, $type, $options);
            }
        }

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $data = $form->getData();

                if (empty($data['published_lower'])) {
                    unset($data['published_lower']);
                    unset($data['published_upper']);
                } else {
                    $data['published_lower'] = $data['published_lower']->getTimestamp() * 1000;
                    $data['published_upper'] = $data['published_upper']->getTimestamp() * 1000;
                }

                return $this->redirect($this->generateUrl('bangpound_castle_search_result', $data));
            }
        }

        return $this->render('BangpoundCastleSearchBundle:Default:search.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function resultAction(Request $request)
    {
        $query = $request->query->all();

        return $this->render('BangpoundCastleSearchBundle:Default:result.html.twig', array('query' => $query));
    }
}
