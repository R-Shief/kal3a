<?php

namespace Rshief\PubsubBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Status
 *
 * @ORM\Table("atom_status")
 * @ORM\Entity
 * @JMS\XmlRoot("status")
 */
class Status
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
     * @var FeedTopic
     *
     * @ORM\ManyToOne(targetEntity="FeedTopic", inversedBy="statuses")
     * @ORM\JoinColumn(name="feed_topic_id")
     * @JMS\Exclude
     */
    private $feedTopic;

    /**
     * @var Integer
     *
     * @ORM\Column(name="http_code", type="integer", nullable=true)
     */
    private $httpCode;

    /**
     * @var \String
     *
     * @ORM\Column(name="http", type="string", length=255)
     */
    private $http;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="next_fetch", type="datetime")
     */
    private $nextFetch;

    /**
     * @var integer
     *
     * @ORM\Column(name="entries_count_since_last_maintenance", type="integer")
     */
    private $entriesCountSinceLastMaintenance;

    /**
     * @var integer
     *
     * @ORM\Column(name="period", type="integer")
     */
    private $period;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_fetch", type="datetime")
     */
    private $lastFetch;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_parse", type="datetime")
     */
    private $lastParse;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_maintenance_at", type="datetime")
     */
    private $lastMaintenanceAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="headers", type="text")
     */
    private $headers;

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
     * Set code
     *
     * @param $http_code
     * @return Status
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    /**
     * Get http
     *
     * @return integer
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * Set http
     *
     * @param $http
     * @return Status
     */
    public function setHttp($http)
    {
        $this->http = $http;

        return $this;
    }

    /**
     * Get http message
     *
     * @return string
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * Set nextFetch
     *
     * @param DateTime $nextFetch
     * @return Status
     */
    public function setNextFetch($nextFetch)
    {
        $this->nextFetch = $nextFetch;

        return $this;
    }

    /**
     * Get nextFetch
     *
     * @return DateTime
     */
    public function getNextFetch()
    {
        return $this->nextFetch;
    }

    /**
     * Set entriesCountSinceLastMaintenance
     *
     * @param integer $entriesCountSinceLastMaintenance
     * @return Status
     */
    public function setEntriesCountSinceLastMaintenance($entriesCountSinceLastMaintenance)
    {
        $this->entriesCountSinceLastMaintenance = $entriesCountSinceLastMaintenance;

        return $this;
    }

    /**
     * Get entriesCountSinceLastMaintenance
     *
     * @return integer
     */
    public function getEntriesCountSinceLastMaintenance()
    {
        return $this->entriesCountSinceLastMaintenance;
    }

    /**
     * Set period
     *
     * @param integer $period
     * @return Status
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return integer
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set lastFetch
     *
     * @param DateTime $lastFetch
     * @return Status
     */
    public function setLastFetch($lastFetch)
    {
        $this->lastFetch = $lastFetch;

        return $this;
    }

    /**
     * Get lastFetch
     *
     * @return DateTime
     */
    public function getLastFetch()
    {
        return $this->lastFetch;
    }

    /**
     * Set lastParse
     *
     * @param DateTime $lastParse
     * @return Status
     */
    public function setLastParse($lastParse)
    {
        $this->lastParse = $lastParse;

        return $this;
    }

    /**
     * Get lastParse
     *
     * @return DateTime
     */
    public function getLastParse()
    {
        return $this->lastParse;
    }

    /**
     * Set lastMaintenanceAt
     *
     * @param DateTime $lastMaintenanceAt
     * @return Status
     */
    public function setLastMaintenanceAt($lastMaintenanceAt)
    {
        $this->lastMaintenanceAt = $lastMaintenanceAt;

        return $this;
    }

    /**
     * Get lastMaintenanceAt
     *
     * @return DateTime
     */
    public function getLastMaintenanceAt()
    {
        return $this->lastMaintenanceAt;
    }

    public function getFeedTopic()
    {
        return $this->feedTopic;
    }

    /**
     *
     * @param FeedTopicInterface $feedTopic
     * @return Status
     */
    public function setFeedTopic(FeedTopicInterface $feedTopic)
    {
        $this->feedTopic = $feedTopic;
        return $this;
    }

    public function __construct()
    {
        $this->timestamp = new DateTime;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp = NULL)
    {
        if (!$timestamp) {
            $timestamp = new DateTime;
        }
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }
}
