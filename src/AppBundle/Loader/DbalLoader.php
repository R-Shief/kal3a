<?php

namespace AppBundle\Loader;

use Doctrine\DBAL\Connection;
use Symfony\Component\Config\Loader\Loader;

class DbalLoader extends Loader
{
    /**
     * Loads a resource.
     *
     * @param \Doctrine\DBAL\Connection $conn
     * @param string|null               $type The resource type or null if unknown
     *
     * @return array If something went wrong
     */
    public function load($conn, $type = null)
    {
        $params = [];

        $qb = $conn->createQueryBuilder();
        $query = $qb->select('phrase')->from('track')->where('is_active = 1')->orderBy('id');
        $stmt = $conn->query($query);

        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $params['track'] = $rows;

        $qb = $conn->createQueryBuilder();
        $query = $qb->select('user_id')->from('follow')->where('is_active = 1')->orderBy('id');
        $stmt = $conn->query($query);

        $rows = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $params['follow'] = $rows;

        $qb = $conn->createQueryBuilder();
        $query = $qb->select('south', 'west', 'north', 'east')->from('location')->where('is_active = 1')->orderBy('id');
        $stmt = $conn->query($query);

        $rows = $stmt->fetchAll(\PDO::FETCH_NUM);
        $rows = array_map(function ($row) {
            return $row;
        }, $rows);
        $params['locations'] = $rows;

        return $params;
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed       $resource A resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return $resource instanceof Connection;
    }
}
