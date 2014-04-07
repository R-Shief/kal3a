<?php

namespace Rshief\Bundle\MigrationBundle\Entity;

/**
 * VBulletinForum
 */
class VBulletinForum
{
    /**
     * @var integer
     */
    private $styleid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $titleClean;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $descriptionClean;

    /**
     * @var integer
     */
    private $options;

    /**
     * @var boolean
     */
    private $showprivate;

    /**
     * @var integer
     */
    private $displayorder;

    /**
     * @var integer
     */
    private $replycount;

    /**
     * @var integer
     */
    private $lastpost;

    /**
     * @var string
     */
    private $lastposter;

    /**
     * @var integer
     */
    private $lastpostid;

    /**
     * @var string
     */
    private $lastthread;

    /**
     * @var integer
     */
    private $lastthreadid;

    /**
     * @var integer
     */
    private $lasticonid;

    /**
     * @var string
     */
    private $lastprefixid;

    /**
     * @var integer
     */
    private $threadcount;

    /**
     * @var integer
     */
    private $daysprune;

    /**
     * @var string
     */
    private $newpostemail;

    /**
     * @var string
     */
    private $newthreademail;

    /**
     * @var integer
     */
    private $parentid;

    /**
     * @var string
     */
    private $parentlist;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $childlist;

    /**
     * @var string
     */
    private $defaultsortfield;

    /**
     * @var string
     */
    private $defaultsortorder;

    /**
     * @var string
     */
    private $imageprefix;

    /**
     * @var integer
     */
    private $vbseoModeratepingbacks;

    /**
     * @var integer
     */
    private $vbseoModeratetrackbacks;

    /**
     * @var integer
     */
    private $vbseoModeraterefbacks;

    /**
     * @var integer
     */
    private $vbseoEnableLikes;

    /**
     * @var boolean
     */
    private $twitterenabled;

    /**
     * @var integer
     */
    private $forumid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $threads;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->threads = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set styleid
     *
     * @param  integer        $styleid
     * @return VBulletinForum
     */
    public function setStyleid($styleid)
    {
        $this->styleid = $styleid;

        return $this;
    }

    /**
     * Get styleid
     *
     * @return integer
     */
    public function getStyleid()
    {
        return $this->styleid;
    }

    /**
     * Set title
     *
     * @param  string         $title
     * @return VBulletinForum
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
     * Set titleClean
     *
     * @param  string         $titleClean
     * @return VBulletinForum
     */
    public function setTitleClean($titleClean)
    {
        $this->titleClean = $titleClean;

        return $this;
    }

    /**
     * Get titleClean
     *
     * @return string
     */
    public function getTitleClean()
    {
        return $this->titleClean;
    }

    /**
     * Set description
     *
     * @param  string         $description
     * @return VBulletinForum
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set descriptionClean
     *
     * @param  string         $descriptionClean
     * @return VBulletinForum
     */
    public function setDescriptionClean($descriptionClean)
    {
        $this->descriptionClean = $descriptionClean;

        return $this;
    }

    /**
     * Get descriptionClean
     *
     * @return string
     */
    public function getDescriptionClean()
    {
        return $this->descriptionClean;
    }

    /**
     * Set options
     *
     * @param  integer        $options
     * @return VBulletinForum
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
     * Set showprivate
     *
     * @param  boolean        $showprivate
     * @return VBulletinForum
     */
    public function setShowprivate($showprivate)
    {
        $this->showprivate = $showprivate;

        return $this;
    }

    /**
     * Get showprivate
     *
     * @return boolean
     */
    public function getShowprivate()
    {
        return $this->showprivate;
    }

    /**
     * Set displayorder
     *
     * @param  integer        $displayorder
     * @return VBulletinForum
     */
    public function setDisplayorder($displayorder)
    {
        $this->displayorder = $displayorder;

        return $this;
    }

    /**
     * Get displayorder
     *
     * @return integer
     */
    public function getDisplayorder()
    {
        return $this->displayorder;
    }

    /**
     * Set replycount
     *
     * @param  integer        $replycount
     * @return VBulletinForum
     */
    public function setReplycount($replycount)
    {
        $this->replycount = $replycount;

        return $this;
    }

    /**
     * Get replycount
     *
     * @return integer
     */
    public function getReplycount()
    {
        return $this->replycount;
    }

    /**
     * Set lastpost
     *
     * @param  integer        $lastpost
     * @return VBulletinForum
     */
    public function setLastpost($lastpost)
    {
        $this->lastpost = $lastpost;

        return $this;
    }

    /**
     * Get lastpost
     *
     * @return integer
     */
    public function getLastpost()
    {
        return $this->lastpost;
    }

    /**
     * Set lastposter
     *
     * @param  string         $lastposter
     * @return VBulletinForum
     */
    public function setLastposter($lastposter)
    {
        $this->lastposter = $lastposter;

        return $this;
    }

    /**
     * Get lastposter
     *
     * @return string
     */
    public function getLastposter()
    {
        return $this->lastposter;
    }

    /**
     * Set lastpostid
     *
     * @param  integer        $lastpostid
     * @return VBulletinForum
     */
    public function setLastpostid($lastpostid)
    {
        $this->lastpostid = $lastpostid;

        return $this;
    }

    /**
     * Get lastpostid
     *
     * @return integer
     */
    public function getLastpostid()
    {
        return $this->lastpostid;
    }

    /**
     * Set lastthread
     *
     * @param  string         $lastthread
     * @return VBulletinForum
     */
    public function setLastthread($lastthread)
    {
        $this->lastthread = $lastthread;

        return $this;
    }

    /**
     * Get lastthread
     *
     * @return string
     */
    public function getLastthread()
    {
        return $this->lastthread;
    }

    /**
     * Set lastthreadid
     *
     * @param  integer        $lastthreadid
     * @return VBulletinForum
     */
    public function setLastthreadid($lastthreadid)
    {
        $this->lastthreadid = $lastthreadid;

        return $this;
    }

    /**
     * Get lastthreadid
     *
     * @return integer
     */
    public function getLastthreadid()
    {
        return $this->lastthreadid;
    }

    /**
     * Set lasticonid
     *
     * @param  integer        $lasticonid
     * @return VBulletinForum
     */
    public function setLasticonid($lasticonid)
    {
        $this->lasticonid = $lasticonid;

        return $this;
    }

    /**
     * Get lasticonid
     *
     * @return integer
     */
    public function getLasticonid()
    {
        return $this->lasticonid;
    }

    /**
     * Set lastprefixid
     *
     * @param  string         $lastprefixid
     * @return VBulletinForum
     */
    public function setLastprefixid($lastprefixid)
    {
        $this->lastprefixid = $lastprefixid;

        return $this;
    }

    /**
     * Get lastprefixid
     *
     * @return string
     */
    public function getLastprefixid()
    {
        return $this->lastprefixid;
    }

    /**
     * Set threadcount
     *
     * @param  integer        $threadcount
     * @return VBulletinForum
     */
    public function setThreadcount($threadcount)
    {
        $this->threadcount = $threadcount;

        return $this;
    }

    /**
     * Get threadcount
     *
     * @return integer
     */
    public function getThreadcount()
    {
        return $this->threadcount;
    }

    /**
     * Set daysprune
     *
     * @param  integer        $daysprune
     * @return VBulletinForum
     */
    public function setDaysprune($daysprune)
    {
        $this->daysprune = $daysprune;

        return $this;
    }

    /**
     * Get daysprune
     *
     * @return integer
     */
    public function getDaysprune()
    {
        return $this->daysprune;
    }

    /**
     * Set newpostemail
     *
     * @param  string         $newpostemail
     * @return VBulletinForum
     */
    public function setNewpostemail($newpostemail)
    {
        $this->newpostemail = $newpostemail;

        return $this;
    }

    /**
     * Get newpostemail
     *
     * @return string
     */
    public function getNewpostemail()
    {
        return $this->newpostemail;
    }

    /**
     * Set newthreademail
     *
     * @param  string         $newthreademail
     * @return VBulletinForum
     */
    public function setNewthreademail($newthreademail)
    {
        $this->newthreademail = $newthreademail;

        return $this;
    }

    /**
     * Get newthreademail
     *
     * @return string
     */
    public function getNewthreademail()
    {
        return $this->newthreademail;
    }

    /**
     * Set parentid
     *
     * @param  integer        $parentid
     * @return VBulletinForum
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
     * Set parentlist
     *
     * @param  string         $parentlist
     * @return VBulletinForum
     */
    public function setParentlist($parentlist)
    {
        $this->parentlist = $parentlist;

        return $this;
    }

    /**
     * Get parentlist
     *
     * @return string
     */
    public function getParentlist()
    {
        return $this->parentlist;
    }

    /**
     * Set password
     *
     * @param  string         $password
     * @return VBulletinForum
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set link
     *
     * @param  string         $link
     * @return VBulletinForum
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set childlist
     *
     * @param  string         $childlist
     * @return VBulletinForum
     */
    public function setChildlist($childlist)
    {
        $this->childlist = $childlist;

        return $this;
    }

    /**
     * Get childlist
     *
     * @return string
     */
    public function getChildlist()
    {
        return $this->childlist;
    }

    /**
     * Set defaultsortfield
     *
     * @param  string         $defaultsortfield
     * @return VBulletinForum
     */
    public function setDefaultsortfield($defaultsortfield)
    {
        $this->defaultsortfield = $defaultsortfield;

        return $this;
    }

    /**
     * Get defaultsortfield
     *
     * @return string
     */
    public function getDefaultsortfield()
    {
        return $this->defaultsortfield;
    }

    /**
     * Set defaultsortorder
     *
     * @param  string         $defaultsortorder
     * @return VBulletinForum
     */
    public function setDefaultsortorder($defaultsortorder)
    {
        $this->defaultsortorder = $defaultsortorder;

        return $this;
    }

    /**
     * Get defaultsortorder
     *
     * @return string
     */
    public function getDefaultsortorder()
    {
        return $this->defaultsortorder;
    }

    /**
     * Set imageprefix
     *
     * @param  string         $imageprefix
     * @return VBulletinForum
     */
    public function setImageprefix($imageprefix)
    {
        $this->imageprefix = $imageprefix;

        return $this;
    }

    /**
     * Get imageprefix
     *
     * @return string
     */
    public function getImageprefix()
    {
        return $this->imageprefix;
    }

    /**
     * Set vbseoModeratepingbacks
     *
     * @param  integer        $vbseoModeratepingbacks
     * @return VBulletinForum
     */
    public function setVbseoModeratepingbacks($vbseoModeratepingbacks)
    {
        $this->vbseoModeratepingbacks = $vbseoModeratepingbacks;

        return $this;
    }

    /**
     * Get vbseoModeratepingbacks
     *
     * @return integer
     */
    public function getVbseoModeratepingbacks()
    {
        return $this->vbseoModeratepingbacks;
    }

    /**
     * Set vbseoModeratetrackbacks
     *
     * @param  integer        $vbseoModeratetrackbacks
     * @return VBulletinForum
     */
    public function setVbseoModeratetrackbacks($vbseoModeratetrackbacks)
    {
        $this->vbseoModeratetrackbacks = $vbseoModeratetrackbacks;

        return $this;
    }

    /**
     * Get vbseoModeratetrackbacks
     *
     * @return integer
     */
    public function getVbseoModeratetrackbacks()
    {
        return $this->vbseoModeratetrackbacks;
    }

    /**
     * Set vbseoModeraterefbacks
     *
     * @param  integer        $vbseoModeraterefbacks
     * @return VBulletinForum
     */
    public function setVbseoModeraterefbacks($vbseoModeraterefbacks)
    {
        $this->vbseoModeraterefbacks = $vbseoModeraterefbacks;

        return $this;
    }

    /**
     * Get vbseoModeraterefbacks
     *
     * @return integer
     */
    public function getVbseoModeraterefbacks()
    {
        return $this->vbseoModeraterefbacks;
    }

    /**
     * Set vbseoEnableLikes
     *
     * @param  integer        $vbseoEnableLikes
     * @return VBulletinForum
     */
    public function setVbseoEnableLikes($vbseoEnableLikes)
    {
        $this->vbseoEnableLikes = $vbseoEnableLikes;

        return $this;
    }

    /**
     * Get vbseoEnableLikes
     *
     * @return integer
     */
    public function getVbseoEnableLikes()
    {
        return $this->vbseoEnableLikes;
    }

    /**
     * Set twitterenabled
     *
     * @param  boolean        $twitterenabled
     * @return VBulletinForum
     */
    public function setTwitterenabled($twitterenabled)
    {
        $this->twitterenabled = $twitterenabled;

        return $this;
    }

    /**
     * Get twitterenabled
     *
     * @return boolean
     */
    public function getTwitterenabled()
    {
        return $this->twitterenabled;
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
     * Add threads
     *
     * @param  \Rshief\Bundle\MigrationBundle\Entity\VBulletinThread $threads
     * @return VBulletinForum
     */
    public function addThread(\Rshief\Bundle\MigrationBundle\Entity\VBulletinThread $threads)
    {
        $this->threads[] = $threads;

        return $this;
    }

    /**
     * Remove threads
     *
     * @param \Rshief\Bundle\MigrationBundle\Entity\VBulletinThread $threads
     */
    public function removeThread(\Rshief\Bundle\MigrationBundle\Entity\VBulletinThread $threads)
    {
        $this->threads->removeElement($threads);
    }

    /**
     * Get threads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThreads()
    {
        return $this->threads;
    }
}
