<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Track.
 *
 * @ORM\Entity
 */
class Track extends \Bangpound\Bundle\TwitterStreamingBundle\Entity\Track
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var StreamParameters
     *
     * @ORM\ManyToOne(targetEntity="StreamParameters", inversedBy="track")
     */
    protected $streamParameters;

    /**
     * @return StreamParameters
     */
    public function getStreamParameters()
    {
        return $this->streamParameters;
    }

    /**
     * @param StreamParameters $streamParameters
     */
    public function setStreamParameters(StreamParameters $streamParameters = null)
    {
        $this->streamParameters = $streamParameters;
    }
}
