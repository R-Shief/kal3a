<?php

namespace Rshief\PubsubBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Sputnik\Bundle\PubsubBundle\Entity\Topic;
use Sputnik\Bundle\PubsubBundle\Model\TopicInterface;

/**
 * Feed topic
 *
 * @ORM\Table(name="atom_feed_topic")
 * @ORM\Entity
 */
class FeedTopic implements FeedTopicInterface
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
     * @var Status
     *
     * @ORM\OneToMany(targetEntity="Status", mappedBy="feedTopic", cascade={"persist", "merge", "remove"})
     * @JMS\Type("ArrayCollection<Rshief\PubsubBundle\Entity\Status>")
     * @JMS\XmlList(entry="status")
     * @JMS\Exclude
     */
    private $statuses;

    /**
     * @var TopicInterface
     *
     * @ORM\OneToOne(targetEntity="Sputnik\Bundle\PubsubBundle\Entity\Topic")
     * @ORM\JoinColumn(name="topic_id", referencedColumnName="id", unique=true, onDelete="set null")
     */
    private $topic;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set topic
     *
     * @param TopicInterface $topic
     * @return FeedTopic
     */
    public function setTopic(TopicInterface $topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * Get topic
     *
     * @return TopicInterface
     */
    public function getTopic()
    {
        return $this->topic;
    }

    public function __construct()
    {
        $this->statuses = new ArrayCollection();
    }

    public function getStatuses()
    {
        return $this->statuses;
    }

    public function setStatuses(ArrayCollection $statuses)
    {
        $statuses->map(
            function ($status) {
                $this->addStatus($status);
            }
        );
        return $this;
    }

    public function addStatus(Status $status)
    {
        $status->setFeedTopic($this);
        $this->statuses[] = $status;
    }

    public function __toString()
    {
        if (empty($this->topic)) {
            return 'New';
        }
        return $this->getTopic()->__toString();
    }
}
