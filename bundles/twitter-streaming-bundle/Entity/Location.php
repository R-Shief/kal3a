<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location.
 *
 * @ORM\Table("location")
 * @ORM\Entity(repositoryClass="Bangpound\Bundle\TwitterStreamingBundle\Entity\FilterRepository")
 */
class Location implements FilterInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="south", type="float")
     */
    private $south;

    /**
     * @var float
     *
     * @ORM\Column(name="west", type="float")
     */
    private $west;

    /**
     * @var float
     *
     * @ORM\Column(name="north", type="float")
     */
    private $north;

    /**
     * @var float
     *
     * @ORM\Column(name="east", type="float")
     */
    private $east;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = true;

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return Track
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

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
