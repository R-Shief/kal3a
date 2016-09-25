<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;
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
     * @Serializer\Groups({"default"})
     *
     * @var string
     */
    protected $language;

    /**
     * @var string[]
     *
     * @ORM\Column(type="json_array")
     * @Serializer\Groups({"default"})
     *
     * @Assert\Count(
     *   min = "0",
     *   max = "400"
     * )
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Length(max=60)
     * })
     */
    protected $track = [];

    /**
     * @var int[]
     *
     * @ORM\Column(type="json_array")
     *
     * @Assert\Count(
     *   min = "0",
     *   max = "5000"
     * )
     * @Assert\All({@Assert\Type("integer")})
     */
    protected $follow = [];

    /**
     * @var array[]
     *
     * @ORM\Column(type="json_array")
     * @Serializer\Groups({"default"})
     *
     * @Assert\Count(
     *   min = "0",
     *   max = "25"
     * )
     * @Assert\All({
     *     @Assert\Collection(fields={
     *       {@Assert\Type("float"),@Assert\Range(min=-180,max=180)},
     *       {@Assert\Type("float"),@Assert\Range(min=-90,max=90)},
     *       {@Assert\Type("float"),@Assert\Range(min=-180,max=180)},
     *       {@Assert\Type("float"),@Assert\Range(min=-90,max=90)}
     *     })
     * })
     */
    protected $locations = [];

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
     * @return string[]
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param string $track
     */
    public function addTrack(string $track)
    {
        $this->track[] = $track;
    }

    /**
     * @param string $track
     */
    public function removeTrack(string $track)
    {
        $this->track = array_diff($this->track, [$track]);
    }

    /**
     * @return int[]
     */
    public function getFollow()
    {
        return $this->follow;
    }

    /**
     * @param int $follow
     */
    public function addFollow(int $follow)
    {
        $this->follow[] = $follow;
    }

    /**
     * @param int $follow
     */
    public function removeFollow(int $follow)
    {
        $this->follow = array_diff($this->follow, [$follow]);
    }

    /**
     * @return array[]
     */
    public function getLocations()
    {
        return $this->locations;
    }

    public function setLocations(array $locations)
    {
        $this->locations = array_values($locations);
    }
}
