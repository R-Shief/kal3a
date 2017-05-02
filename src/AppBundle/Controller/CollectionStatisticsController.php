<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Symfony\Component\Intl\Intl;

class CollectionStatisticsController extends Controller
{
    /**
     * @Sensio\Template
     * @return array
     * @Sensio\Cache(expires="+1 hour", public=true)
     */
    public function dailyAction()
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $settings = array(
          'title' => 'Daily',
          'body' => 'Count of items per day for last week.',
        );
        $query = $conn->createViewQuery('timeseries', 'published');

        $query->setStale('ok');
        $query->setLimit(7);
        $query->setDescending(true);
        $query->setReduce(true);
        $query->setGroup(true);
        $query->setGroupLevel(3);

        $date_key = 0;
        $format = 'M-d-Y';
        $results = [];
        foreach ($query->execute() as $result) {
            $date = date($format, mktime(
              isset($result['key'][$date_key + 3]) ? $result['key'][$date_key + 3] : 0,
              isset($result['key'][$date_key + 4]) ? $result['key'][$date_key + 4] : 0,
              isset($result['key'][$date_key + 5]) ? $result['key'][$date_key + 5] : 0,
              isset($result['key'][$date_key + 1]) ? $result['key'][$date_key + 1] : 0,
              isset($result['key'][$date_key + 2]) ? $result['key'][$date_key + 2] : 0,
              isset($result['key'][$date_key]) ? $result['key'][$date_key] : 0
            ));
            if ($date_key > 0) {
                $results[$result['key'][0]][$date] = $result['value'];
            } else {
                $results[$date] = $result['value'];
            }
        }

        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    /**
     * @Sensio\Template("AppBundle:CollectionStatistics:daily.html.twig")
     *
     * @return array
     * @Sensio\Cache(expires="+1 hour", public=true)
     */
    public function hourlyAction()
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $settings = array(
          'title' => 'Hourly',
          'body' => 'Count of items per hour for last 24 hours.',
        );
        $query = $conn->createViewQuery('timeseries', 'published');

        $query->setStale('ok');
        $query->setLimit(24);
        $query->setDescending(true);
        $query->setReduce(true);
        $query->setGroup(true);
        $query->setGroupLevel(4);

        $date_key = 0;
        $format = 'H:i';
        $results = [];
        foreach ($query->execute() as $result) {
            $date = date($format, mktime(
              isset($result['key'][$date_key + 3]) ? $result['key'][$date_key + 3] : 0,
              isset($result['key'][$date_key + 4]) ? $result['key'][$date_key + 4] : 0,
              isset($result['key'][$date_key + 5]) ? $result['key'][$date_key + 5] : 0,
              isset($result['key'][$date_key + 1]) ? $result['key'][$date_key + 1] : 0,
              isset($result['key'][$date_key + 2]) ? $result['key'][$date_key + 2] : 0,
              isset($result['key'][$date_key]) ? $result['key'][$date_key] : 0
            ));
            if ($date_key > 0) {
                $results[$result['key'][0]][$date] = $result['value'];
            } else {
                $results[$date] = $result['value'];
            }
        }

        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    /**
     * @Sensio\Template
     * @return array
     */
    public function collectionAction()
    {
        $map = $this->container->getParameter('bangpound_castle.types');
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $settings = array(
          'title' => 'Collections',
          'body' => 'Count of items in each collection.',
        );
        $query = $conn->createViewQuery('collection', 'timeseries');
        $query->setGroup(true);
        $query->setStale('ok');

        $results = array();
        foreach ($query->execute() as $result) {
            $results[] = [
              'key' => $result['key'][0],
              'label' => isset($map[$result['key'][0]]) ? $map[$result['key'][0]] : $result['key'][0],
              'value' => $result['value'],
            ];
        }

        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    /**
     * @Sensio\Template("AppBundle:CollectionStatistics:language.html.twig")
     * @return array
     */
    public function languageAction()
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $start = new \DateTime('-1 month');
        $end = new \DateTime();
        $settings = array(
          'title' => 'Languages',
          'body' => 'Collected from '.$start->format('n M').' to '.$end->format('n M'),
        );
        $query = $conn->createViewQuery('tags', 'lang');
        $query->setGroup(true);
        $query->setStale('ok');
        $query->setGroupLevel(1);

        $map = $this->languagesArrayAction();

        $results = array();
        foreach ($query->execute() as $result) {
            $results[] = [
              'key' => $result['key'],
              'label' => isset($map[$result['key']]) ? $map[$result['key']] : $result['key'],
              'value' => $result['value'],
            ];
        }

        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    /**
     * @Sensio\Template
     * @Sensio\ParamConverter("start", options={"format": "Y-m-d"})
     * @Sensio\ParamConverter("end", options={"format": "Y-m-d"})
     * @return array
     */
    public function topTagAction(\DateTime $start, \DateTime $end, $title, $body = '')
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $dm */
        $conn = $this->get('doctrine_couchdb.client.default_connection');
        $settings = array(
          'title' => $title,
          'body' => $body,
        );

        $startKey = array((int) $start->format('Y'), (int) $start->format('m'), (int) $start->format('d'));
        $endKey = array((int) $end->format('Y'), (int) $end->format('m'), (int) $end->format('d'));

        /**
         * @var \Doctrine\CouchDB\View\Query $query
         */
        $query = $conn->createViewQuery('tags', 'timeseries');
        $query->setStale('ok');
        $query->setLimit(10);
        $query->setGroup(true);
        $query->setGroupLevel(6);
        $query->setStartKey($startKey);
        $query->setEndKey($endKey);
        $query->setDescending(true);

        $results = array();

        foreach ($query->execute() as $result) {
            $results[$result['key'][5]] = $result['value'];
        }


        return array(
          'query'     => $query,
          'results'   => $results,
          'settings'  => $settings,
        );
    }

    public function languagesArrayAction()
    {
        return Intl::getLanguageBundle()->getLanguageNames();
    }
}
