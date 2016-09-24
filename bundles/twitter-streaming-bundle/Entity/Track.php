<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Track.
 */
class Track
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
     * @var string
     *
     * @ORM\Column(name="phrase", type="string", length=60)
     *
     * @Assert\NotBlank
     * @Assert\Length(max=60)
     */
    protected $phrase;

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
