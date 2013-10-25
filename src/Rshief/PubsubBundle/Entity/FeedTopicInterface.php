<?php

namespace Rshief\PubsubBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sputnik\Bundle\PubsubBundle\Model\TopicInterface;

interface FeedTopicInterface
{
    public function getId();

    public function setTopic(TopicInterface $topic);

    public function getTopic();

    public function getStatuses();

    public function setStatuses(ArrayCollection $statuses);

    public function addStatus(Status $status);
}
