<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Location.
 *
 * @ORM\Entity
 */
class Location extends \Bangpound\Bundle\TwitterStreamingBundle\Entity\Location
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
     * @ORM\ManyToOne(targetEntity="StreamParameters", inversedBy="locations")
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
