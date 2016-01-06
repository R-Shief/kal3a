<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Entity;

use Doctrine\ORM\EntityRepository;

class FilterRepository extends EntityRepository
{
    public function findActiveTracks()
    {
        $result = $this->getEntityManager()
            ->createQuery('SELECT t.phrase FROM BangpoundTwitterStreamingBundle:Track t WHERE t.isActive = true')
            ->getScalarResult();

        return array_map('current', $result);
    }

    public function findActiveLocations()
    {
        $result = $this->getEntityManager()
            ->createQuery('SELECT t.west,t.south,t.east,t.north FROM BangpoundTwitterStreamingBundle:Location t WHERE t.isActive = true')
            ->getScalarResult();

        return array_map('array_values', $result);
    }

    public function findActiveFollows()
    {
        $result = $this->getEntityManager()
            ->createQuery('SELECT t.userId FROM BangpoundTwitterStreamingBundle:Follow t WHERE t.isActive = true')
            ->getScalarResult();

        return array_map('current', $result);
    }
}
