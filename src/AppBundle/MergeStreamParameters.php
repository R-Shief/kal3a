<?php

namespace AppBundle;

use AppBundle\Entity\StreamParameters;

class MergeStreamParameters
{
    /**
     * @param StreamParameters[] $streamParameters
     * @return StreamParameters
     */
    public function merge(array $streamParameters)
    {
        $mergedStreamParameters = new StreamParameters();
        /** @var StreamParameters $streamParameter */
        foreach ($streamParameters as $streamParameter) {
            $mergedStreamParameters->setTrack(array_merge($mergedStreamParameters->getTrack(), $streamParameter->getTrack()));
            $mergedStreamParameters->setLocations(array_merge($mergedStreamParameters->getLocations(), $streamParameter->getLocations()));
            $mergedStreamParameters->setFollow(array_merge($mergedStreamParameters->getFollow(), $streamParameter->getFollow()));
        }

        return $mergedStreamParameters;
    }
}
