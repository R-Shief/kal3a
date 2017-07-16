<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Query
 *
 * @ORM\Table(name="query")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QueryRepository")
 */
class Query
{
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $term;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedEnd;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @Gedmo\Blameable(on="create")
     */
    protected $createdBy;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @Gedmo\Blameable(on="update")
     */
    protected $updatedBy;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set q
     *
     * @param string $q
     *
     * @return Query
     */
    public function setQ($q)
    {
        $this->q = $q;

        return $this;
    }

    /**
     * Get q
     *
     * @return string
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * Set term
     *
     * @param string $term
     *
     * @return Query
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get term
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set publishedStart
     *
     * @param \DateTime $publishedStart
     *
     * @return Query
     */
    public function setPublishedStart($publishedStart)
    {
        $this->publishedStart = $publishedStart;

        return $this;
    }

    /**
     * Get publishedStart
     *
     * @return \DateTime
     */
    public function getPublishedStart()
    {
        return $this->publishedStart;
    }

    /**
     * Set publishedEnd
     *
     * @param \DateTime $publishedEnd
     *
     * @return Query
     */
    public function setPublishedEnd($publishedEnd)
    {
        $this->publishedEnd = $publishedEnd;

        return $this;
    }

    /**
     * Get publishedEnd
     *
     * @return \DateTime
     */
    public function getPublishedEnd()
    {
        return $this->publishedEnd;
    }
}
