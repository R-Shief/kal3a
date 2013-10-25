<?php

namespace Rshief\TwitterMinerBundle\Stream;

use Bangpound\PhirehoseBundle\Stream\BasicStream;

class RshiefStream extends BasicStream
{

    public function checkFilterPredicates()
    {
        /* @var Rshief\TwitterMinerBundle\Entity\FilterRepository $repository */
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
