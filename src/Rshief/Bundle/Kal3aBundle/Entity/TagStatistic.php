<?php

namespace Rshief\Bundle\Kal3aBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TagStatistic
 *
 * @ORM\Table(name="tag_statistics", uniqueConstraints={@ORM\UniqueConstraint(columns={"tag", "timestamp", "period"})}, options={"collate"="utf8_bin"})
 * @ORM\Entity
 */
class TagStatistic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=139)
     */
    private $tag;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="period", type="string", length=4)
     */
    private $period;

    /**
     * @var integer
     *
     * @ORM\Column(name="sum", type="integer")
     */
    private $sum;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var integer
     *
     * @ORM\Column(name="min", type="integer")
     */
    private $min;

    /**
     * @var integer
     *
     * @ORM\Column(name="max", type="integer")
     */
    private $max;

    /**
     * @var integer
     *
     * @ORM\Column(name="sumsqr", type="integer")
     */
    private $sumsqr;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tag
     *
     * @param  string       $tag
     * @return TagStatistic
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set timestamp
     *
     * @param  \DateTime    $timestamp
     * @return TagStatistic
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Set period
     *
     * @param  string       $period
     * @return TagStatistic
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set sum
     *
     * @param  integer      $sum
     * @return TagStatistic
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return integer
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set count
     *
     * @param  integer      $count
     * @return TagStatistic
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set min
     *
     * @param  integer      $min
     * @return TagStatistic
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Get min
     *
     * @return integer
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param  integer      $max
     * @return TagStatistic
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get max
     *
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set sumsqr
     *
     * @param  integer      $sumsqr
     * @return TagStatistic
     */
    public function setSumsqr($sumsqr)
    {
        $this->sumsqr = $sumsqr;

        return $this;
    }

    /**
     * Get sumsqr
     *
     * @return integer
     */
    public function getSumsqr()
    {
        return $this->sumsqr;
    }
}
