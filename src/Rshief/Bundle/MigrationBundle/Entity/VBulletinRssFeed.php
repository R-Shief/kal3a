<?php

namespace Rshief\Bundle\MigrationBundle\Entity;

/**
 * VBulletinRssFeed
 */
class VBulletinRssFeed
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $port;

    /**
     * @var integer
     */
    private $ttl;

    /**
     * @var integer
     */
    private $maxresults;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var integer
     */
    private $forumid;

    /**
     * @var string
     */
    private $prefixid;

    /**
     * @var integer
     */
    private $iconid;

    /**
     * @var string
     */
    private $titletemplate;

    /**
     * @var string
     */
    private $bodytemplate;

    /**
     * @var string
     */
    private $searchwords;

    /**
     * @var string
     */
    private $itemtype;

    /**
     * @var integer
     */
    private $threadactiondelay;

    /**
     * @var integer
     */
    private $endannouncement;

    /**
     * @var integer
     */
    private $options;

    /**
     * @var integer
     */
    private $lastrun;

    /**
     * @var integer
     */
    private $threadid;

    /**
     * @var integer
     */
    private $tuMaxtime;

    /**
     * @var string
     */
    private $tuReason;

    /**
     * @var string
     */
    private $tuHs;

    /**
     * @var string
     */
    private $tuHe;

    /**
     * @var integer
     */
    private $sntaXP;

    /**
     * @var integer
     */
    private $rssfeedid;

    /**
     * Set title
     *
     * @param  string           $title
     * @return VBulletinRssFeed
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param  string           $url
     * @return VBulletinRssFeed
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set port
     *
     * @param  integer          $port
     * @return VBulletinRssFeed
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set ttl
     *
     * @param  integer          $ttl
     * @return VBulletinRssFeed
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Get ttl
     *
     * @return integer
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * Set maxresults
     *
     * @param  integer          $maxresults
     * @return VBulletinRssFeed
     */
    public function setMaxresults($maxresults)
    {
        $this->maxresults = $maxresults;

        return $this;
    }

    /**
     * Get maxresults
     *
     * @return integer
     */
    public function getMaxresults()
    {
        return $this->maxresults;
    }

    /**
     * Set userid
     *
     * @param  integer          $userid
     * @return VBulletinRssFeed
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set forumid
     *
     * @param  integer          $forumid
     * @return VBulletinRssFeed
     */
    public function setForumid($forumid)
    {
        $this->forumid = $forumid;

        return $this;
    }

    /**
     * Get forumid
     *
     * @return integer
     */
    public function getForumid()
    {
        return $this->forumid;
    }

    /**
     * Set prefixid
     *
     * @param  string           $prefixid
     * @return VBulletinRssFeed
     */
    public function setPrefixid($prefixid)
    {
        $this->prefixid = $prefixid;

        return $this;
    }

    /**
     * Get prefixid
     *
     * @return string
     */
    public function getPrefixid()
    {
        return $this->prefixid;
    }

    /**
     * Set iconid
     *
     * @param  integer          $iconid
     * @return VBulletinRssFeed
     */
    public function setIconid($iconid)
    {
        $this->iconid = $iconid;

        return $this;
    }

    /**
     * Get iconid
     *
     * @return integer
     */
    public function getIconid()
    {
        return $this->iconid;
    }

    /**
     * Set titletemplate
     *
     * @param  string           $titletemplate
     * @return VBulletinRssFeed
     */
    public function setTitletemplate($titletemplate)
    {
        $this->titletemplate = $titletemplate;

        return $this;
    }

    /**
     * Get titletemplate
     *
     * @return string
     */
    public function getTitletemplate()
    {
        return $this->titletemplate;
    }

    /**
     * Set bodytemplate
     *
     * @param  string           $bodytemplate
     * @return VBulletinRssFeed
     */
    public function setBodytemplate($bodytemplate)
    {
        $this->bodytemplate = $bodytemplate;

        return $this;
    }

    /**
     * Get bodytemplate
     *
     * @return string
     */
    public function getBodytemplate()
    {
        return $this->bodytemplate;
    }

    /**
     * Set searchwords
     *
     * @param  string           $searchwords
     * @return VBulletinRssFeed
     */
    public function setSearchwords($searchwords)
    {
        $this->searchwords = $searchwords;

        return $this;
    }

    /**
     * Get searchwords
     *
     * @return string
     */
    public function getSearchwords()
    {
        return $this->searchwords;
    }

    /**
     * Set itemtype
     *
     * @param  string           $itemtype
     * @return VBulletinRssFeed
     */
    public function setItemtype($itemtype)
    {
        $this->itemtype = $itemtype;

        return $this;
    }

    /**
     * Get itemtype
     *
     * @return string
     */
    public function getItemtype()
    {
        return $this->itemtype;
    }

    /**
     * Set threadactiondelay
     *
     * @param  integer          $threadactiondelay
     * @return VBulletinRssFeed
     */
    public function setThreadactiondelay($threadactiondelay)
    {
        $this->threadactiondelay = $threadactiondelay;

        return $this;
    }

    /**
     * Get threadactiondelay
     *
     * @return integer
     */
    public function getThreadactiondelay()
    {
        return $this->threadactiondelay;
    }

    /**
     * Set endannouncement
     *
     * @param  integer          $endannouncement
     * @return VBulletinRssFeed
     */
    public function setEndannouncement($endannouncement)
    {
        $this->endannouncement = $endannouncement;

        return $this;
    }

    /**
     * Get endannouncement
     *
     * @return integer
     */
    public function getEndannouncement()
    {
        return $this->endannouncement;
    }

    /**
     * Set options
     *
     * @param  integer          $options
     * @return VBulletinRssFeed
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return integer
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set lastrun
     *
     * @param  integer          $lastrun
     * @return VBulletinRssFeed
     */
    public function setLastrun($lastrun)
    {
        $this->lastrun = $lastrun;

        return $this;
    }

    /**
     * Get lastrun
     *
     * @return integer
     */
    public function getLastrun()
    {
        return $this->lastrun;
    }

    /**
     * Set threadid
     *
     * @param  integer          $threadid
     * @return VBulletinRssFeed
     */
    public function setThreadid($threadid)
    {
        $this->threadid = $threadid;

        return $this;
    }

    /**
     * Get threadid
     *
     * @return integer
     */
    public function getThreadid()
    {
        return $this->threadid;
    }

    /**
     * Set tuMaxtime
     *
     * @param  integer          $tuMaxtime
     * @return VBulletinRssFeed
     */
    public function setTuMaxtime($tuMaxtime)
    {
        $this->tuMaxtime = $tuMaxtime;

        return $this;
    }

    /**
     * Get tuMaxtime
     *
     * @return integer
     */
    public function getTuMaxtime()
    {
        return $this->tuMaxtime;
    }

    /**
     * Set tuReason
     *
     * @param  string           $tuReason
     * @return VBulletinRssFeed
     */
    public function setTuReason($tuReason)
    {
        $this->tuReason = $tuReason;

        return $this;
    }

    /**
     * Get tuReason
     *
     * @return string
     */
    public function getTuReason()
    {
        return $this->tuReason;
    }

    /**
     * Set tuHs
     *
     * @param  string           $tuHs
     * @return VBulletinRssFeed
     */
    public function setTuHs($tuHs)
    {
        $this->tuHs = $tuHs;

        return $this;
    }

    /**
     * Get tuHs
     *
     * @return string
     */
    public function getTuHs()
    {
        return $this->tuHs;
    }

    /**
     * Set tuHe
     *
     * @param  string           $tuHe
     * @return VBulletinRssFeed
     */
    public function setTuHe($tuHe)
    {
        $this->tuHe = $tuHe;

        return $this;
    }

    /**
     * Get tuHe
     *
     * @return string
     */
    public function getTuHe()
    {
        return $this->tuHe;
    }

    /**
     * Set sntaXP
     *
     * @param  integer          $sntaXP
     * @return VBulletinRssFeed
     */
    public function setSntaXP($sntaXP)
    {
        $this->sntaXP = $sntaXP;

        return $this;
    }

    /**
     * Get sntaXP
     *
     * @return integer
     */
    public function getSntaXP()
    {
        return $this->sntaXP;
    }

    /**
     * Get rssfeedid
     *
     * @return integer
     */
    public function getRssfeedid()
    {
        return $this->rssfeedid;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
