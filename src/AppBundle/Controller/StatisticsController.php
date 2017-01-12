<?php

namespace AppBundle\Controller;

use Doctrine\CouchDB\CouchDBClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Symfony\Component\Intl\Intl;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation as Nelmio;

/**
 * Class StatisticsController.
 *
 * @FOSRest\Route("/api/statistics", service="bangpound_castle_search.controller.statistics")
 */
class StatisticsController
{
    /**
     * @var CouchDBClient
     */
    private $conn;

    public function __construct(CouchDBClient $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Counts of entries by published time.
     *
     * @Sensio\ParamConverter("start", options={"format": "Y-m-d"})
     * @Sensio\ParamConverter("end", options={"format": "Y-m-d"})
     * @Sensio\Cache(maxage="3600", public=true, vary={"Accept-Encoding", "Origin"})
     * @FOSRest\QueryParam(name="start")
     * @FOSRest\QueryParam(name="end")
     * @FOSRest\QueryParam(name="group", requirements="(hourly|daily)")
     * @FOSRest\QueryParam(name="limit")
     * @FOSRest\Route("/published", methods={"GET"})
     * @FOSRest\View
     * @Nelmio\ApiDoc
     *
     * @param \DateTime $start
     * @param \DateTime $end
     * @param $group
     * @param $limit
     *
     * @return array
     */
    public function publishedTimeseriesAction(\DateTime $start, \DateTime $end, $group, $limit)
    {
        $params = array(
          'hourly' => ['group_level' => 4, 'format' => 'H:i'],
          'daily' => ['group_level' => 3, 'format' => 'M-d-Y'],
        );
        $query = $this->conn->createViewQuery('published', 'timeseries');

        $query->setStale('ok');
        $query->setLimit($limit);
        $query->setDescending($start > $end);
        $query->setReduce(true);
        $query->setGroup(true);
        $query->setGroupLevel($params[$group]['group_level']);

        $results = array();

        if ($query) {
            $date_key = 0;
            $format = $params[$group]['format'];
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
        }

        return $results;
    }

    /**
     * @FOSRest\Route("/language", methods={"GET"})
     * @Nelmio\ApiDoc
     * @FOSRest\View
     *
     * @return array
     */
    public function languageAction()
    {
        $query = $this->conn->createViewQuery('lang', 'basic');
        $query->setGroup(true);
        $query->setStale('ok');
        $query->setGroupLevel(1);

        $map = Intl::getLanguageBundle()->getLanguageNames();

        $results = array();
        foreach ($query->execute() as $result) {
            $results[] = [
              'key' => $result['key'],
              'label' => isset($map[$result['key']]) ? $map[$result['key']] : $result['key'],
              'value' => $result['value'],
            ];
        }

        return $results;
    }

    /**
     * @Sensio\ParamConverter("start", options={"format": "Y-m-d"})
     * @Sensio\ParamConverter("end", options={"format": "Y-m-d"})
     * @FOSRest\QueryParam(name="start")
     * @FOSRest\QueryParam(name="end")
     * @FOSRest\Route("/top-tag", methods={"GET"})
     * @FOSRest\View
     * @Nelmio\ApiDoc
     *
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     */
    public function topTagAction(\DateTime $start, \DateTime $end)
    {
        $startKey = array((int) $start->format('Y'), (int) $start->format('m'), (int) $start->format('d'));
        $endKey = array((int) $end->format('Y'), (int) $end->format('m'), (int) $end->format('d'));

        /*
         * @var \Doctrine\CouchDB\View\Query
         */
        $query = $this->conn->createViewQuery('tag_trends', 'PT1M');
        $query->setStale('ok');
        $query->setLimit(10);
        $query->setGroup(true);
        $query->setGroupLevel(6);
        $query->setStartKey($startKey);
        $query->setEndKey($endKey);
        $query->setDescending($start > $end);

        $results = array();

        foreach ($query->execute() as $result) {
            $results[$result['key'][5]] = $result['value'];
        }

        return $results;
    }
}
