<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Location.
 */
class Location
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
     * @var float
     *
     * @ORM\Column(name="south", type="float")
     * @Assert\Type("float")
     * @Assert\Range(min=-180,max=180)
     */
    protected $south;

    /**
     * @var float
     *
     * @ORM\Column(name="west", type="float")
     * @Assert\Type("float")
     * @Assert\Range(min=-90,max=90)
     */
    protected $west;

    /**
     * @var float
     *
     * @ORM\Column(name="north", type="float")
     * @Assert\Type("float")
     * @Assert\Range(min=-180,max=180)
     */
    protected $north;

    /**
     * @var float
     *
     * @ORM\Column(name="east", type="float")
     * @Assert\Type("float")
     * @Assert\Range(min=-90,max=90)
     */
    protected $east;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set south.
     *
     * @param float $south
     *
     * @return Location
     */
    public function setSouth($south)
    {
        $this->south = $south;

        return $this;
    }

    /**
     * Get south.
     *
     * @return float
     */
    public function getSouth()
    {
        return $this->south;
    }

    /**
     * Set west.
     *
     * @param float $west
     *
     * @return Location
     */
    public function setWest($west)
    {
        $this->west = $west;

        return $this;
    }

    /**
     * Get west.
     *
     * @return float
     */
    public function getWest()
    {
        return $this->west;
    }

    /**
     * Set north.
     *
     * @param float $north
     *
     * @return Location
     */
    public function setNorth($north)
    {
        $this->north = $north;

        return $this;
    }

    /**
     * Get north.
     *
     * @return float
     */
    public function getNorth()
    {
        return $this->north;
    }

    /**
     * Set east.
     *
     * @param float $east
     *
     * @return Location
     */
    public function setEast($east)
    {
        $this->east = $east;

        return $this;
    }

    /**
     * Get east.
     *
     * @return float
     */
    public function getEast()
    {
        return $this->east;
    }
}
