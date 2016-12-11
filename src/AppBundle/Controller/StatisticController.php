<?php

namespace AppBundle\Controller;

use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\View\Result;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * Class StatisticsController.
 *
 * @FOSRest\RouteResource("Tag")
 */
class StatisticController extends FOSRestController
{
    /**
     * @Nelmio\ApiDoc
     * @FOSRest\View(serializerGroups={"default"})
     *
     * @param string $tag   Tag
     * @param int    $group CouchDB view group level
     *
     * @return \FOS\RestBundle\View\View
     */
    public function getStatisticsAction(string $tag, int $group = 4)
    {
        $tag = strtolower(ltrim($tag, '#'));
        $dm = $this->get('doctrine_couchdb');

        /** @var CouchDBClient $default_client */
        $default_client = $dm->getConnection();

        $query = $default_client->createViewQuery('tag', 'timeseries');
        $query->setStale('ok');

        // All other executions will allow stale results.
        $query->setGroup(true);
        $query->setGroupLevel($group);
        $query->setIncludeDocs(false);
        $query->setReduce(true);

        $query->setStartKey([$tag]);
        $query->setEndKey([$tag, []]);

        /** @var Result $result */
        $result = $query->execute();

        return array_map(function ($value) use ($group) {
            if ($group > 1) {
                $date = new \DateTime();
            }
            else {
                $date = 'all';
            }
            if ($group === 2) {
                $date->setDate($value['key'][1], 0, 1);
            }
            if ($group === 3) {
                $date->setDate($value['key'][1], $value['key'][2], 1);
            }
            if ($group >= 4) {
                $date->setDate($value['key'][1], $value['key'][2], $value['key'][3]);
            }
            if ($group < 5 && $group > 1) {
                $date->setTime(0, 0);
            }
            if ($group === 5) {
                $date->setTime($value['key'][4], 0);
            }
            if ($group === 6) {
                $date->setTime($value['key'][4], $value['key'][5]);
            }
            if ($group === 7) {
                $date->setTime($value['key'][4], $value['key'][5], $value['key'][6]);
            }
            if ($group > 1) {
                $date = $date->format(\DateTime::RFC3339);
            }

            return array(
              $date => $value['value'],
            );
        }, $result->toArray());
    }

    /**
     * @Nelmio\ApiDoc
     *
     * @throws \LogicException
     * @Sensio\Cache(maxage="3600", public=true, vary={"Accept-Encoding", "Origin"})
     * @FOSRest\View
     */
    public function getSummaryAction()
    {
        $output = array();
        $tr = $this->getDoctrine()->getRepository('AppBundle:StreamParameters');

        $streamParameters = $tr->findAll();
        foreach ($streamParameters as $streamParameter) {
            foreach ($streamParameter->getTrack() as $track) {
                $output[$track] = $this->getStatisticsAction($track);
                $output['_total'][$track] = $this->getStatisticsAction($track, 1);
            }
        }

        return $output;
    }
}
