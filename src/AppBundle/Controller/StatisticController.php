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
     * @FOSRest\Get(requirements={"group"="\d+"}, defaults={"group"="4"})
     * @FOSRest\View(serializerGroups={"default"})
     *
     * @param string $tag   Tag
     * @param int    $group CouchDB view group level
     *
     * @return \FOS\RestBundle\View\View
     */
    public function getStatisticsAction($tag, int $group = 4)
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

        if ($group === 4) {
            return array_map(function ($value) {
                $date = new \DateTime();
                $date->setDate($value['key'][1], $value['key'][2], $value['key'][3]);
                $date->setTime(0, 0);
                $date = $date->format('Y-m-d');

                return array(
                    $date => $value['value'],
                );
            }, $result->toArray());
        } else {
            return $result[0]['value'];
        }
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
