<?php

namespace Rshief\Bundle\MigrationBundle\Entity;

/**
 * VBulletinPost
 */
class VBulletinPost
{
    /**
     * @var integer
     */
    private $threadid;

    /**
     * @var integer
     */
    private $parentid;

    /**
     * @var string
     */
    private $username;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $dateline;

    /**
     * @var string
     */
    private $pagetext;

    /**
     * @var integer
     */
    private $allowsmilie;

    /**
     * @var integer
     */
    private $showsignature;

    /**
     * @var string
     */
    private $ipaddress;

    /**
     * @var integer
     */
    private $iconid;

    /**
     * @var integer
     */
    private $visible;

    /**
     * @var integer
     */
    private $attach;

    /**
     * @var integer
     */
    private $infraction;

    /**
     * @var integer
     */
    private $reportthreadid;

    /**
     * @var boolean
     */
    private $ameFlag;

    /**
     * @var integer
     */
    private $postid;

    /**
     * @var \Rshief\Bundle\MigrationBundle\Entity\VBulletinThread
     */
    private $thread;

    /**
     * @var \Rshief\Bundle\MigrationBundle\Entity\VBulletinUser
     */
    private $user;

    /**
     * Set threadid
     *
     * @param  integer       $threadid
     * @return VBulletinPost
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
     * Set parentid
     *
     * @param  integer       $parentid
     * @return VBulletinPost
     */
    public function setParentid($parentid)
    {
        $this->parentid = $parentid;

        return $this;
    }

    /**
     * Get parentid
     *
     * @return integer
     */
    public function getParentid()
    {
        return $this->parentid;
    }

    /**
     * Set username
     *
     * @param  string        $username
     * @return VBulletinPost
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set userid
     *
     * @param  integer       $userid
     * @return VBulletinPost
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
     * Set title
     *
     * @param  string        $title
     * @return VBulletinPost
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
     * Set dateline
     *
     * @param  integer       $dateline
     * @return VBulletinPost
     */
    public function setDateline($dateline)
    {
        $this->dateline = $dateline;

        return $this;
    }

    /**
     * Get dateline
     *
     * @return integer
     */
    public function getDateline()
    {
        return $this->dateline;
    }

    /**
     * Set pagetext
     *
     * @param  string        $pagetext
     * @return VBulletinPost
     */
    public function setPagetext($pagetext)
    {
        $this->pagetext = $pagetext;

        return $this;
    }

    /**
     * Get pagetext
     *
     * @return string
     */
    public function getPagetext()
    {
        return $this->pagetext;
    }

    /**
     * Set allowsmilie
     *
     * @param  integer       $allowsmilie
     * @return VBulletinPost
     */
    public function setAllowsmilie($allowsmilie)
    {
        $this->allowsmilie = $allowsmilie;

        return $this;
    }

    /**
     * Get allowsmilie
     *
     * @return integer
     */
    public function getAllowsmilie()
    {
        return $this->allowsmilie;
    }

    /**
     * Set showsignature
     *
     * @param  integer       $showsignature
     * @return VBulletinPost
     */
    public function setShowsignature($showsignature)
    {
        $this->showsignature = $showsignature;

        return $this;
    }

    /**
     * Get showsignature
     *
     * @return integer
     */
    public function getShowsignature()
    {
        return $this->showsignature;
    }

    /**
     * Set ipaddress
     *
     * @param  string        $ipaddress
     * @return VBulletinPost
     */
    public function setIpaddress($ipaddress)
    {
        $this->ipaddress = $ipaddress;

        return $this;
    }

    /**
     * Get ipaddress
     *
     * @return string
     */
    public function getIpaddress()
    {
        return $this->ipaddress;
    }

    /**
     * Set iconid
     *
     * @param  integer       $iconid
     * @return VBulletinPost
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
     * Set visible
     *
     * @param  integer       $visible
     * @return VBulletinPost
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return integer
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set attach
     *
     * @param  integer       $attach
     * @return VBulletinPost
     */
    public function setAttach($attach)
    {
        $this->attach = $attach;

        return $this;
    }

    /**
     * Get attach
     *
     * @return integer
     */
    public function getAttach()
    {
        return $this->attach;
    }

    /**
     * Set infraction
     *
     * @param  integer       $infraction
     * @return VBulletinPost
     */
    public function setInfraction($infraction)
    {
        $this->infraction = $infraction;

        return $this;
    }

    /**
     * Get infraction
     *
     * @return integer
     */
    public function getInfraction()
    {
        return $this->infraction;
    }

    /**
     * Set reportthreadid
     *
     * @param  integer       $reportthreadid
     * @return VBulletinPost
     */
    public function setReportthreadid($reportthreadid)
    {
        $this->reportthreadid = $reportthreadid;

        return $this;
    }

    /**
     * Get reportthreadid
     *
     * @return integer
     */
    public function getReportthreadid()
    {
        return $this->reportthreadid;
    }

    /**
     * Set ameFlag
     *
     * @param  boolean       $ameFlag
     * @return VBulletinPost
     */
    public function setAmeFlag($ameFlag)
    {
        $this->ameFlag = $ameFlag;

        return $this;
    }

    /**
     * Get ameFlag
     *
     * @return boolean
     */
    public function getAmeFlag()
    {
        return $this->ameFlag;
    }

    /**
     * Get postid
     *
     * @return integer
     */
    public function getPostid()
    {
        return $this->postid;
    }

    /**
     * Set thread
     *
     * @param  \Rshief\Bundle\MigrationBundle\Entity\VBulletinThread $thread
     * @return VBulletinPost
     */
    public function setThread(\Rshief\Bundle\MigrationBundle\Entity\VBulletinThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Rshief\Bundle\MigrationBundle\Entity\VBulletinThread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set user
     *
     * @param  \Rshief\Bundle\MigrationBundle\Entity\VBulletinUser $user
     * @return VBulletinPost
     */
    public function setUser(\Rshief\Bundle\MigrationBundle\Entity\VBulletinUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Rshief\Bundle\MigrationBundle\Entity\VBulletinUser
     */
    public function getUser()
    {
        return $this->user;
    }
}
