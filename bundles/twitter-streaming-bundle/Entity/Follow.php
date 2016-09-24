<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Follow.
 */
class Follow
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
     * @ORM\Column(name="user_id", type="bigint", options={"unsigned"=true})
     *
     * @Assert\Type("integer")
     */
    protected $userId;

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
     * Set screenName.
     *
     * @param string $userId
     *
     * @return Follow
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get screenName.
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function __toString()
    {
        return $this->getUserId();
    }
}
