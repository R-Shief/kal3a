<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Track.
 *
 * @ORM\Table("track")
 * @ORM\Entity(repositoryClass="Bangpound\Bundle\TwitterStreamingBundle\Entity\FilterRepository")
 */
class Track implements FilterInterface
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
     * @var string
     *
     * @ORM\Column(name="phrase", type="string", length=60)
     */
    private $phrase;

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
     * Set phrase.
     *
     * @param string $phrase
     *
     * @return Track
     */
    public function setPhrase($phrase)
    {
        $this->phrase = $phrase;

        return $this;
    }

    /**
     * Get phrase.
     *
     * @return string
     */
    public function getPhrase()
    {
        return $this->phrase;
    }

    public function __toString()
    {
        return (string) $this->getPhrase();
    }
}
