<?php

namespace Application\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;

class Group extends BaseGroup
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Get id.
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}
