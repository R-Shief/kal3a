<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Entity;

interface FilterInterface
{
    public function setIsActive($isActive);
    public function getIsActive();
}
