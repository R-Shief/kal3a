<?php

namespace Rshief\Bundle\Kal3aBundle\Controller;

use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * Class StatisticsController
 * @package Rshief\Bundle\Kal3aBundle\Controller
 * @RouteResource("TagStatistics")
 */
class StatisticsController extends FOSRestController
{
    /**
     * @return mixed
     */
    public function cgetAction()
    {
        /** @var Connection $conn */
        $conn = $this->get('database_connection');
        $queryBuilder = $conn->createQueryBuilder();

        /** @var \Doctrine\DBAL\Statement $query */
        $query = $queryBuilder->select('DISTINCT t.tag')
            ->from('tag_statistics', 't')
            ->execute();

        $result = $query->fetchAll();
        return $result;
    }

    public function getAction($tag)
    {
        /** @var Connection $conn */
        $conn = $this->get('database_connection');
        $queryBuilder = $conn->createQueryBuilder();

        /** @var \Doctrine\DBAL\Statement $query */
        $query = $queryBuilder->select('t.timestamp', 't.count')
            ->from('tag_statistics', 't')
            ->where('t.tag = ?')
            ->setParameter(0, $tag)
            ->execute();

        $result = $query->fetchAll();
        return $result;
    }
}
