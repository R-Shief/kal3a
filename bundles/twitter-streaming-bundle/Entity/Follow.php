<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Follow
 *
 * @ORM\Table("follow")
 * @ORM\Entity(repositoryClass="Bangpound\Bundle\TwitterStreamingBundle\Entity\FilterRepository")
 */
class Follow implements FilterInterface
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
     * @ORM\Column(name="user_id", type="bigint", options={"unsigned"=true})
     */
    private $userId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = true;

    /**
     * Set isActive
     *
     * @param  boolean $isActive
     * @return Track
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

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
     * Set screenName
     *
     * @param  string $userId
     * @return Follow
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get screenName
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
