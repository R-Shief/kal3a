<?php

namespace Rshief\Bundle\Kal3aBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TagTrend
 *
 * @ORM\Table(name="tag_trend", options={"collate"="utf8_bin"})
 * @ORM\Entity
 */
class TagTrend
{
    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=139)
     */
    private $tag;

    /**
     * @var float
     *
     * @ORM\Column(name="slope", type="float", precision=10, scale=0, nullable=true)
     */
    private $slope;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return float
     */
    public function getSlope()
    {
        return $this->slope;
    }

    /**
     * @param float $slope
     */
    public function setSlope($slope)
    {
        $this->slope = $slope;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
