<?php

namespace Rshief\Bundle\Kal3aBundle\Controller;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatisticsController
 * @package Rshief\Bundle\Kal3aBundle\Controller
 * @RouteResource("TagStatistic")
 */
class StatisticController extends FOSRestController
{
    /**
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     */
    public function cgetAction(Request $request)
    {
        $q = $request->get('q');

        /** @var Connection $conn */
        $conn = $this->get('database_connection');

        if ($q) {
            $result = $conn->executeQuery('SELECT DISTINCT tag FROM tag_statistics WHERE tag LIKE ?', array($q .'%'))->fetchAll(Query::HYDRATE_SCALAR);
        } else {
            $result = $conn->executeQuery('SELECT DISTINCT tag FROM tag_statistics')->fetchAll(Query::HYDRATE_SCALAR);
        }
        $result = array_map(function ($value) { return $value[0]; }, $result);

        return $result;
    }

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

        $result = $query->fetchAll();

        return $result;
    }
}
