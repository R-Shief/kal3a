<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Stream;

use Bangpound\PhirehoseBundle\Stream\BasicStream;

class DoctrineStream extends BasicStream
{

    public function checkFilterPredicates()
    {
        /* @var \Bangpound\Bundle\TwitterStreamingBundle\Entity\FilterRepository $repository */
        $repository = $this->em->getRepository('BangpoundTwitterStreamingBundle:Track');

        $track = $repository->findActiveTracks();
        if ($track != $this->getTrack()) {
            $this->setTrack($track);
        }

        $follow = $repository->findActiveFollows();
        if ($follow != $this->getFollow()) {
            $this->setFollow($follow);
        }

        $location = $repository->findActiveLocations();
        if ($location != $this->getLocations()) {
            $this->setLocations($location);
        }
    }
}
