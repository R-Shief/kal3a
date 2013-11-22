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

    public function searchAction()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('bangpound_castle_search_result'))
            ->setMethod('GET')
            ->add('queryTerm', 'text')
            ->add('date', 'date')
            ->add('search', 'submit')
            ->getForm();

        $manager = $this->get('doctrine_couchdb.odm.default_document_manager');
        $query = $manager
            ->createNativeQuery('stats', 'daily')
            ->setDescending(true)
            ->setReduce(true)
            ->setGroup(true)
            ->setGroupLevel(3);
        $results_daily = array();
        foreach ($query->execute() as $result) {
            $date = date("M-d-Y", mktime(0, 0, 0, $result['key'][1], $result['key'][2], $result['key'][0]));
            $results_daily[$date] = $result['value'];
        }

        $query = $manager
            ->createNativeQuery('stats', 'daily')
            ->setDescending(true)
            ->setReduce(true)
            ->setGroup(true)
            ->setGroupLevel(4);
        $results_hourly = array();
        foreach ($query->execute() as $result) {
            $date = date("M-d-Y H:i:s", mktime($result['key'][3], 0, 0, $result['key'][1], $result['key'][2], $result['key'][0]));
            $results_hourly[$date] = $result['value'];
        }

        return $this->render('BangpoundCastleSearchBundle:Default:search.html.twig', array(
            'form' => $form->createView(),
            'results_daily' => $results_daily,
            'results_hourly' => $results_hourly,
        ));
    }
}
