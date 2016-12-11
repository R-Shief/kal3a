<?php

namespace AppBundle\Controller;

use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\View\Result;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * Class StatisticsController.
 *
 * @RouteResource("TagStatistic")
 */
class StatisticController extends FOSRestController
{
    /**
     * @Nelmio\ApiDoc
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return mixed
     */
    public function cgetAction(Request $request)
    {
        $q = $request->get('q');

        /** @var Connection $conn */
        $conn = $this->get('database_connection');

        if ($q) {
            $result = $conn->executeQuery('SELECT DISTINCT tag FROM tag_statistics WHERE tag LIKE ?', array($q.'%'))->fetchAll(Query::HYDRATE_SCALAR);
        } else {
            $result = $conn->executeQuery('SELECT DISTINCT tag FROM tag_statistics')->fetchAll(Query::HYDRATE_SCALAR);
        }
        $result = array_map(function ($value) {
            return $value[0];
        }, $result);

        return $result;
    }

    /**
     * @Nelmio\ApiDoc
     *
     * @param $tag
     *
     * @return array
     */
    public function getAction($tag)
    {
        /** @var Connection $conn */
        $conn = $this->get('database_connection');
        $queryBuilder = $conn->createQueryBuilder();

        /** @var \Doctrine\DBAL\Statement $query */
        $query = $queryBuilder->select('t.timestamp', 't.sum')
            ->from('tag_statistics', 't')
            ->where('t.tag = ?')
            ->setParameter(0, $tag)
            ->execute();

        return $query->fetchAll();
    }

    /**
     * @Nelmio\ApiDoc
     * @FOSRest\View(serializerGroups={"default"})
     *
     * @param string $tag
     * @param int    $group
     *
     * @return \FOS\RestBundle\View\View
     */
    public function getStatisticsAction($tag, $group = 4)
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
