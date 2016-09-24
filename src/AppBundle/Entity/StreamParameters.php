<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StreamParameters.
 *
 * @ORM\Entity
 * @ORM\Table
 */
class StreamParameters
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @Assert\Language()
     *
     * @ORM\Column(nullable=true)
     *
     * @var string
     */
    protected $language;

    /**
     * @var Track[]
     *
     * @ORM\OneToMany(targetEntity="Track", mappedBy="streamParameters", cascade={"all"}, orphanRemoval=true)
     *
     * @Assert\Count(
     *   min = "0",
     *   max = "400"
     * )
     * @Assert\Valid(traverse=true)
     */
    protected $track;

    /**
     * @var Follow[]
     *
     * @ORM\OneToMany(targetEntity="Follow", mappedBy="streamParameters", cascade={"all"}, orphanRemoval=true)
     *
     * @Assert\Count(
     *   min = "0",
     *   max = "5000"
     * )
     * @Assert\Valid(traverse=true)
     */
    protected $follow;

    /**
     * @var Location[]
     *
     * @ORM\OneToMany(targetEntity="Location", mappedBy="streamParameters", cascade={"all"}, orphanRemoval=true)
     *
     * @Assert\Count(
     *   min = "0",
     *   max = "25"
     * )
     * @Assert\Valid(traverse=true)
     */
    protected $locations;

    /**
     * StreamParameters constructor.
     */
    public function __construct()
    {
        $this->follow = new ArrayCollection();
        $this->track = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return Track[]
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param Track $track
     */
    public function addTrack(Track $track)
    {
        $this->track[] = $track;
        $track->setStreamParameters($this);
    }

    /**
     * @param Track $track
     */
    public function removeTrack(Track $track)
    {
        $this->track->removeElement($track);
        $track->setStreamParameters(null);
    }

    /**
     * @return Follow[]
     */
    public function getFollow()
    {
        return $this->follow;
    }

    /**
     * @param Follow $follow
     */
    public function addFollow(Follow $follow)
    {
        $this->follow[] = $follow;
        $follow->setStreamParameters($this);
    }

    /**
     * @param Follow $follow
     */
    public function removeFollow(Follow $follow)
    {
        $this->follow->removeElement($follow);
        $follow->setStreamParameters(null);
    }

    /**
     * @return Location[]
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param Location $location
     */
    public function addLocation(Location $location)
    {
        $this->locations[] = $location;
        $location->setStreamParameters($this);
    }

    /**
     * @param Location $location
     */
    public function removeLocation(Location $location)
    {
        $this->locations->removeElement($location);
        $location->setStreamParameters(null);
    }
}
