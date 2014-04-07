<?php

namespace Rshief\Bundle\MigrationBundle\Entity;

/**
 * VBulletinThread
 */
class VBulletinThread
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $prefixid;

    /**
     * @var integer
     */
    private $firstpostid;

    /**
     * @var integer
     */
    private $lastpostid;

    /**
     * @var integer
     */
    private $lastpost;

    /**
     * @var integer
     */
    private $forumid;

    /**
     * @var integer
     */
    private $pollid;

    /**
     * @var integer
     */
    private $open;

    /**
     * @var integer
     */
    private $replycount;

    /**
     * @var integer
     */
    private $hiddencount;

    /**
     * @var integer
     */
    private $deletedcount;

    /**
     * @var string
     */
    private $postusername;

    /**
     * @var integer
     */
    private $postuserid;

    /**
     * @var string
     */
    private $lastposter;

    /**
     * @var integer
     */
    private $dateline;

    /**
     * @var integer
     */
    private $views;

    /**
     * @var integer
     */
    private $iconid;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var integer
     */
    private $visible;

    /**
     * @var integer
     */
    private $sticky;

    /**
     * @var integer
     */
    private $votenum;

    /**
     * @var integer
     */
    private $votetotal;

    /**
     * @var integer
     */
    private $attach;

    /**
     * @var string
     */
    private $similar;

    /**
     * @var string
     */
    private $taglist;

    /**
     * @var integer
     */
    private $vbseoLinkbacksNo;

    /**
     * @var integer
     */
    private $vbseoLikes;

    /**
     * @var integer
     */
    private $threadidx;

    /**
     * @var string
     */
    private $cmsAuthor;

    /**
     * @var string
     */
    private $cmsContact;

    /**
     * @var string
     */
    private $cmsDate;

    /**
     * @var string
     */
    private $cmsDescription;

    /**
     * @var string
     */
    private $cmsEditor;

    /**
     * @var string
     */
    private $cmsEmbedImage;

    /**
     * @var string
     */
    private $cmsFile;

    /**
     * @var string
     */
    private $cmsHost;

    /**
     * @var string
     */
    private $cmsName;

    /**
     * @var string
     */
    private $cmsOrganization;

    /**
     * @var string
     */
    private $cmsProducedBy;

    /**
     * @var string
     */
    private $cmsPublisher;

    /**
     * @var string
     */
    private $cmsRelatedLinks;

    /**
     * @var string
     */
    private $cmsType;

    /**
     * @var string
     */
    private $cmsUrl;

    /**
     * @var string
     */
    private $field1;

    /**
     * @var string
     */
    private $field2;

    /**
     * @var string
     */
    private $field3;

    /**
     * @var string
     */
    private $field4;

    /**
     * @var string
     */
    private $field5;

    /**
     * @var string
     */
    private $field6;

    /**
     * @var string
     */
    private $field7;

    /**
     * @var string
     */
    private $field10;

    /**
     * @var string
     */
    private $field11;

    /**
     * @var string
     */
    private $field12;

    /**
     * @var string
     */
    private $field13;

    /**
     * @var string
     */
    private $field14;

    /**
     * @var string
     */
    private $field15;

    /**
     * @var string
     */
    private $field16;

    /**
     * @var string
     */
    private $field17;

    /**
     * @var string
     */
    private $field18;

    /**
     * @var string
     */
    private $field19;

    /**
     * @var string
     */
    private $field20;

    /**
     * @var string
     */
    private $field21;

    /**
     * @var string
     */
    private $field22;

    /**
     * @var string
     */
    private $field23;

    /**
     * @var string
     */
    private $field24;

    /**
     * @var string
     */
    private $field25;

    /**
     * @var string
     */
    private $field26;

    /**
     * @var string
     */
    private $field27;

    /**
     * @var string
     */
    private $field28;

    /**
     * @var string
     */
    private $field29;

    /**
     * @var string
     */
    private $field30;

    /**
     * @var string
     */
    private $field31;

    /**
     * @var string
     */
    private $field32;

    /**
     * @var string
     */
    private $field33;

    /**
     * @var string
     */
    private $field34;

    /**
     * @var string
     */
    private $field35;

    /**
     * @var string
     */
    private $field36;

    /**
     * @var string
     */
    private $field37;

    /**
     * @var integer
     */
    private $tweeted;

    /**
     * @var string
     */
    private $tweetScreenName;

    /**
     * @var integer
     */
    private $threadid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $posts;

    /**
     * @var \Rshief\Bundle\MigrationBundle\Entity\VBulletinForum
     */
    private $forum;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set title
     *
     * @param  string          $title
     * @return VBulletinThread
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
     * Set prefixid
     *
     * @param  string          $prefixid
     * @return VBulletinThread
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
     * Set firstpostid
     *
     * @param  integer         $firstpostid
     * @return VBulletinThread
     */
    public function setFirstpostid($firstpostid)
    {
        $this->firstpostid = $firstpostid;

        return $this;
    }

    /**
     * Get firstpostid
     *
     * @return integer
     */
    public function getFirstpostid()
    {
        return $this->firstpostid;
    }

    /**
     * Set lastpostid
     *
     * @param  integer         $lastpostid
     * @return VBulletinThread
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
     * Set lastpost
     *
     * @param  integer         $lastpost
     * @return VBulletinThread
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
     * Set forumid
     *
     * @param  integer         $forumid
     * @return VBulletinThread
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
     * Set pollid
     *
     * @param  integer         $pollid
     * @return VBulletinThread
     */
    public function setPollid($pollid)
    {
        $this->pollid = $pollid;

        return $this;
    }

    /**
     * Get pollid
     *
     * @return integer
     */
    public function getPollid()
    {
        return $this->pollid;
    }

    /**
     * Set open
     *
     * @param  integer         $open
     * @return VBulletinThread
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return integer
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set replycount
     *
     * @param  integer         $replycount
     * @return VBulletinThread
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
     * Set hiddencount
     *
     * @param  integer         $hiddencount
     * @return VBulletinThread
     */
    public function setHiddencount($hiddencount)
    {
        $this->hiddencount = $hiddencount;

        return $this;
    }

    /**
     * Get hiddencount
     *
     * @return integer
     */
    public function getHiddencount()
    {
        return $this->hiddencount;
    }

    /**
     * Set deletedcount
     *
     * @param  integer         $deletedcount
     * @return VBulletinThread
     */
    public function setDeletedcount($deletedcount)
    {
        $this->deletedcount = $deletedcount;

        return $this;
    }

    /**
     * Get deletedcount
     *
     * @return integer
     */
    public function getDeletedcount()
    {
        return $this->deletedcount;
    }

    /**
     * Set postusername
     *
     * @param  string          $postusername
     * @return VBulletinThread
     */
    public function setPostusername($postusername)
    {
        $this->postusername = $postusername;

        return $this;
    }

    /**
     * Get postusername
     *
     * @return string
     */
    public function getPostusername()
    {
        return $this->postusername;
    }

    /**
     * Set postuserid
     *
     * @param  integer         $postuserid
     * @return VBulletinThread
     */
    public function setPostuserid($postuserid)
    {
        $this->postuserid = $postuserid;

        return $this;
    }

    /**
     * Get postuserid
     *
     * @return integer
     */
    public function getPostuserid()
    {
        return $this->postuserid;
    }

    /**
     * Set lastposter
     *
     * @param  string          $lastposter
     * @return VBulletinThread
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
     * Set dateline
     *
     * @param  integer         $dateline
     * @return VBulletinThread
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
     * Set views
     *
     * @param  integer         $views
     * @return VBulletinThread
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set iconid
     *
     * @param  integer         $iconid
     * @return VBulletinThread
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
     * Set notes
     *
     * @param  string          $notes
     * @return VBulletinThread
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set visible
     *
     * @param  integer         $visible
     * @return VBulletinThread
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
     * Set sticky
     *
     * @param  integer         $sticky
     * @return VBulletinThread
     */
    public function setSticky($sticky)
    {
        $this->sticky = $sticky;

        return $this;
    }

    /**
     * Get sticky
     *
     * @return integer
     */
    public function getSticky()
    {
        return $this->sticky;
    }

    /**
     * Set votenum
     *
     * @param  integer         $votenum
     * @return VBulletinThread
     */
    public function setVotenum($votenum)
    {
        $this->votenum = $votenum;

        return $this;
    }

    /**
     * Get votenum
     *
     * @return integer
     */
    public function getVotenum()
    {
        return $this->votenum;
    }

    /**
     * Set votetotal
     *
     * @param  integer         $votetotal
     * @return VBulletinThread
     */
    public function setVotetotal($votetotal)
    {
        $this->votetotal = $votetotal;

        return $this;
    }

    /**
     * Get votetotal
     *
     * @return integer
     */
    public function getVotetotal()
    {
        return $this->votetotal;
    }

    /**
     * Set attach
     *
     * @param  integer         $attach
     * @return VBulletinThread
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
     * Set similar
     *
     * @param  string          $similar
     * @return VBulletinThread
     */
    public function setSimilar($similar)
    {
        $this->similar = $similar;

        return $this;
    }

    /**
     * Get similar
     *
     * @return string
     */
    public function getSimilar()
    {
        return $this->similar;
    }

    /**
     * Set taglist
     *
     * @param  string          $taglist
     * @return VBulletinThread
     */
    public function setTaglist($taglist)
    {
        $this->taglist = $taglist;

        return $this;
    }

    /**
     * Get taglist
     *
     * @return string
     */
    public function getTaglist()
    {
        return $this->taglist;
    }

    /**
     * Set vbseoLinkbacksNo
     *
     * @param  integer         $vbseoLinkbacksNo
     * @return VBulletinThread
     */
    public function setVbseoLinkbacksNo($vbseoLinkbacksNo)
    {
        $this->vbseoLinkbacksNo = $vbseoLinkbacksNo;

        return $this;
    }

    /**
     * Get vbseoLinkbacksNo
     *
     * @return integer
     */
    public function getVbseoLinkbacksNo()
    {
        return $this->vbseoLinkbacksNo;
    }

    /**
     * Set vbseoLikes
     *
     * @param  integer         $vbseoLikes
     * @return VBulletinThread
     */
    public function setVbseoLikes($vbseoLikes)
    {
        $this->vbseoLikes = $vbseoLikes;

        return $this;
    }

    /**
     * Get vbseoLikes
     *
     * @return integer
     */
    public function getVbseoLikes()
    {
        return $this->vbseoLikes;
    }

    /**
     * Set threadidx
     *
     * @param  integer         $threadidx
     * @return VBulletinThread
     */
    public function setThreadidx($threadidx)
    {
        $this->threadidx = $threadidx;

        return $this;
    }

    /**
     * Get threadidx
     *
     * @return integer
     */
    public function getThreadidx()
    {
        return $this->threadidx;
    }

    /**
     * Set cmsAuthor
     *
     * @param  string          $cmsAuthor
     * @return VBulletinThread
     */
    public function setCmsAuthor($cmsAuthor)
    {
        $this->cmsAuthor = $cmsAuthor;

        return $this;
    }

    /**
     * Get cmsAuthor
     *
     * @return string
     */
    public function getCmsAuthor()
    {
        return $this->cmsAuthor;
    }

    /**
     * Set cmsContact
     *
     * @param  string          $cmsContact
     * @return VBulletinThread
     */
    public function setCmsContact($cmsContact)
    {
        $this->cmsContact = $cmsContact;

        return $this;
    }

    /**
     * Get cmsContact
     *
     * @return string
     */
    public function getCmsContact()
    {
        return $this->cmsContact;
    }

    /**
     * Set cmsDate
     *
     * @param  string          $cmsDate
     * @return VBulletinThread
     */
    public function setCmsDate($cmsDate)
    {
        $this->cmsDate = $cmsDate;

        return $this;
    }

    /**
     * Get cmsDate
     *
     * @return string
     */
    public function getCmsDate()
    {
        return $this->cmsDate;
    }

    /**
     * Set cmsDescription
     *
     * @param  string          $cmsDescription
     * @return VBulletinThread
     */
    public function setCmsDescription($cmsDescription)
    {
        $this->cmsDescription = $cmsDescription;

        return $this;
    }

    /**
     * Get cmsDescription
     *
     * @return string
     */
    public function getCmsDescription()
    {
        return $this->cmsDescription;
    }

    /**
     * Set cmsEditor
     *
     * @param  string          $cmsEditor
     * @return VBulletinThread
     */
    public function setCmsEditor($cmsEditor)
    {
        $this->cmsEditor = $cmsEditor;

        return $this;
    }

    /**
     * Get cmsEditor
     *
     * @return string
     */
    public function getCmsEditor()
    {
        return $this->cmsEditor;
    }

    /**
     * Set cmsEmbedImage
     *
     * @param  string          $cmsEmbedImage
     * @return VBulletinThread
     */
    public function setCmsEmbedImage($cmsEmbedImage)
    {
        $this->cmsEmbedImage = $cmsEmbedImage;

        return $this;
    }

    /**
     * Get cmsEmbedImage
     *
     * @return string
     */
    public function getCmsEmbedImage()
    {
        return $this->cmsEmbedImage;
    }

    /**
     * Set cmsFile
     *
     * @param  string          $cmsFile
     * @return VBulletinThread
     */
    public function setCmsFile($cmsFile)
    {
        $this->cmsFile = $cmsFile;

        return $this;
    }

    /**
     * Get cmsFile
     *
     * @return string
     */
    public function getCmsFile()
    {
        return $this->cmsFile;
    }

    /**
     * Set cmsHost
     *
     * @param  string          $cmsHost
     * @return VBulletinThread
     */
    public function setCmsHost($cmsHost)
    {
        $this->cmsHost = $cmsHost;

        return $this;
    }

    /**
     * Get cmsHost
     *
     * @return string
     */
    public function getCmsHost()
    {
        return $this->cmsHost;
    }

    /**
     * Set cmsName
     *
     * @param  string          $cmsName
     * @return VBulletinThread
     */
    public function setCmsName($cmsName)
    {
        $this->cmsName = $cmsName;

        return $this;
    }

    /**
     * Get cmsName
     *
     * @return string
     */
    public function getCmsName()
    {
        return $this->cmsName;
    }

    /**
     * Set cmsOrganization
     *
     * @param  string          $cmsOrganization
     * @return VBulletinThread
     */
    public function setCmsOrganization($cmsOrganization)
    {
        $this->cmsOrganization = $cmsOrganization;

        return $this;
    }

    /**
     * Get cmsOrganization
     *
     * @return string
     */
    public function getCmsOrganization()
    {
        return $this->cmsOrganization;
    }

    /**
     * Set cmsProducedBy
     *
     * @param  string          $cmsProducedBy
     * @return VBulletinThread
     */
    public function setCmsProducedBy($cmsProducedBy)
    {
        $this->cmsProducedBy = $cmsProducedBy;

        return $this;
    }

    /**
     * Get cmsProducedBy
     *
     * @return string
     */
    public function getCmsProducedBy()
    {
        return $this->cmsProducedBy;
    }

    /**
     * Set cmsPublisher
     *
     * @param  string          $cmsPublisher
     * @return VBulletinThread
     */
    public function setCmsPublisher($cmsPublisher)
    {
        $this->cmsPublisher = $cmsPublisher;

        return $this;
    }

    /**
     * Get cmsPublisher
     *
     * @return string
     */
    public function getCmsPublisher()
    {
        return $this->cmsPublisher;
    }

    /**
     * Set cmsRelatedLinks
     *
     * @param  string          $cmsRelatedLinks
     * @return VBulletinThread
     */
    public function setCmsRelatedLinks($cmsRelatedLinks)
    {
        $this->cmsRelatedLinks = $cmsRelatedLinks;

        return $this;
    }

    /**
     * Get cmsRelatedLinks
     *
     * @return string
     */
    public function getCmsRelatedLinks()
    {
        return $this->cmsRelatedLinks;
    }

    /**
     * Set cmsType
     *
     * @param  string          $cmsType
     * @return VBulletinThread
     */
    public function setCmsType($cmsType)
    {
        $this->cmsType = $cmsType;

        return $this;
    }

    /**
     * Get cmsType
     *
     * @return string
     */
    public function getCmsType()
    {
        return $this->cmsType;
    }

    /**
     * Set cmsUrl
     *
     * @param  string          $cmsUrl
     * @return VBulletinThread
     */
    public function setCmsUrl($cmsUrl)
    {
        $this->cmsUrl = $cmsUrl;

        return $this;
    }

    /**
     * Get cmsUrl
     *
     * @return string
     */
    public function getCmsUrl()
    {
        return $this->cmsUrl;
    }

    /**
     * Set field1
     *
     * @param  string          $field1
     * @return VBulletinThread
     */
    public function setField1($field1)
    {
        $this->field1 = $field1;

        return $this;
    }

    /**
     * Get field1
     *
     * @return string
     */
    public function getField1()
    {
        return $this->field1;
    }

    /**
     * Set field2
     *
     * @param  string          $field2
     * @return VBulletinThread
     */
    public function setField2($field2)
    {
        $this->field2 = $field2;

        return $this;
    }

    /**
     * Get field2
     *
     * @return string
     */
    public function getField2()
    {
        return $this->field2;
    }

    /**
     * Set field3
     *
     * @param  string          $field3
     * @return VBulletinThread
     */
    public function setField3($field3)
    {
        $this->field3 = $field3;

        return $this;
    }

    /**
     * Get field3
     *
     * @return string
     */
    public function getField3()
    {
        return $this->field3;
    }

    /**
     * Set field4
     *
     * @param  string          $field4
     * @return VBulletinThread
     */
    public function setField4($field4)
    {
        $this->field4 = $field4;

        return $this;
    }

    /**
     * Get field4
     *
     * @return string
     */
    public function getField4()
    {
        return $this->field4;
    }

    /**
     * Set field5
     *
     * @param  string          $field5
     * @return VBulletinThread
     */
    public function setField5($field5)
    {
        $this->field5 = $field5;

        return $this;
    }

    /**
     * Get field5
     *
     * @return string
     */
    public function getField5()
    {
        return $this->field5;
    }

    /**
     * Set field6
     *
     * @param  string          $field6
     * @return VBulletinThread
     */
    public function setField6($field6)
    {
        $this->field6 = $field6;

        return $this;
    }

    /**
     * Get field6
     *
     * @return string
     */
    public function getField6()
    {
        return $this->field6;
    }

    /**
     * Set field7
     *
     * @param  string          $field7
     * @return VBulletinThread
     */
    public function setField7($field7)
    {
        $this->field7 = $field7;

        return $this;
    }

    /**
     * Get field7
     *
     * @return string
     */
    public function getField7()
    {
        return $this->field7;
    }

    /**
     * Set field10
     *
     * @param  string          $field10
     * @return VBulletinThread
     */
    public function setField10($field10)
    {
        $this->field10 = $field10;

        return $this;
    }

    /**
     * Get field10
     *
     * @return string
     */
    public function getField10()
    {
        return $this->field10;
    }

    /**
     * Set field11
     *
     * @param  string          $field11
     * @return VBulletinThread
     */
    public function setField11($field11)
    {
        $this->field11 = $field11;

        return $this;
    }

    /**
     * Get field11
     *
     * @return string
     */
    public function getField11()
    {
        return $this->field11;
    }

    /**
     * Set field12
     *
     * @param  string          $field12
     * @return VBulletinThread
     */
    public function setField12($field12)
    {
        $this->field12 = $field12;

        return $this;
    }

    /**
     * Get field12
     *
     * @return string
     */
    public function getField12()
    {
        return $this->field12;
    }

    /**
     * Set field13
     *
     * @param  string          $field13
     * @return VBulletinThread
     */
    public function setField13($field13)
    {
        $this->field13 = $field13;

        return $this;
    }

    /**
     * Get field13
     *
     * @return string
     */
    public function getField13()
    {
        return $this->field13;
    }

    /**
     * Set field14
     *
     * @param  string          $field14
     * @return VBulletinThread
     */
    public function setField14($field14)
    {
        $this->field14 = $field14;

        return $this;
    }

    /**
     * Get field14
     *
     * @return string
     */
    public function getField14()
    {
        return $this->field14;
    }

    /**
     * Set field15
     *
     * @param  string          $field15
     * @return VBulletinThread
     */
    public function setField15($field15)
    {
        $this->field15 = $field15;

        return $this;
    }

    /**
     * Get field15
     *
     * @return string
     */
    public function getField15()
    {
        return $this->field15;
    }

    /**
     * Set field16
     *
     * @param  string          $field16
     * @return VBulletinThread
     */
    public function setField16($field16)
    {
        $this->field16 = $field16;

        return $this;
    }

    /**
     * Get field16
     *
     * @return string
     */
    public function getField16()
    {
        return $this->field16;
    }

    /**
     * Set field17
     *
     * @param  string          $field17
     * @return VBulletinThread
     */
    public function setField17($field17)
    {
        $this->field17 = $field17;

        return $this;
    }

    /**
     * Get field17
     *
     * @return string
     */
    public function getField17()
    {
        return $this->field17;
    }

    /**
     * Set field18
     *
     * @param  string          $field18
     * @return VBulletinThread
     */
    public function setField18($field18)
    {
        $this->field18 = $field18;

        return $this;
    }

    /**
     * Get field18
     *
     * @return string
     */
    public function getField18()
    {
        return $this->field18;
    }

    /**
     * Set field19
     *
     * @param  string          $field19
     * @return VBulletinThread
     */
    public function setField19($field19)
    {
        $this->field19 = $field19;

        return $this;
    }

    /**
     * Get field19
     *
     * @return string
     */
    public function getField19()
    {
        return $this->field19;
    }

    /**
     * Set field20
     *
     * @param  string          $field20
     * @return VBulletinThread
     */
    public function setField20($field20)
    {
        $this->field20 = $field20;

        return $this;
    }

    /**
     * Get field20
     *
     * @return string
     */
    public function getField20()
    {
        return $this->field20;
    }

    /**
     * Set field21
     *
     * @param  string          $field21
     * @return VBulletinThread
     */
    public function setField21($field21)
    {
        $this->field21 = $field21;

        return $this;
    }

    /**
     * Get field21
     *
     * @return string
     */
    public function getField21()
    {
        return $this->field21;
    }

    /**
     * Set field22
     *
     * @param  string          $field22
     * @return VBulletinThread
     */
    public function setField22($field22)
    {
        $this->field22 = $field22;

        return $this;
    }

    /**
     * Get field22
     *
     * @return string
     */
    public function getField22()
    {
        return $this->field22;
    }

    /**
     * Set field23
     *
     * @param  string          $field23
     * @return VBulletinThread
     */
    public function setField23($field23)
    {
        $this->field23 = $field23;

        return $this;
    }

    /**
     * Get field23
     *
     * @return string
     */
    public function getField23()
    {
        return $this->field23;
    }

    /**
     * Set field24
     *
     * @param  string          $field24
     * @return VBulletinThread
     */
    public function setField24($field24)
    {
        $this->field24 = $field24;

        return $this;
    }

    /**
     * Get field24
     *
     * @return string
     */
    public function getField24()
    {
        return $this->field24;
    }

    /**
     * Set field25
     *
     * @param  string          $field25
     * @return VBulletinThread
     */
    public function setField25($field25)
    {
        $this->field25 = $field25;

        return $this;
    }

    /**
     * Get field25
     *
     * @return string
     */
    public function getField25()
    {
        return $this->field25;
    }

    /**
     * Set field26
     *
     * @param  string          $field26
     * @return VBulletinThread
     */
    public function setField26($field26)
    {
        $this->field26 = $field26;

        return $this;
    }

    /**
     * Get field26
     *
     * @return string
     */
    public function getField26()
    {
        return $this->field26;
    }

    /**
     * Set field27
     *
     * @param  string          $field27
     * @return VBulletinThread
     */
    public function setField27($field27)
    {
        $this->field27 = $field27;

        return $this;
    }

    /**
     * Get field27
     *
     * @return string
     */
    public function getField27()
    {
        return $this->field27;
    }

    /**
     * Set field28
     *
     * @param  string          $field28
     * @return VBulletinThread
     */
    public function setField28($field28)
    {
        $this->field28 = $field28;

        return $this;
    }

    /**
     * Get field28
     *
     * @return string
     */
    public function getField28()
    {
        return $this->field28;
    }

    /**
     * Set field29
     *
     * @param  string          $field29
     * @return VBulletinThread
     */
    public function setField29($field29)
    {
        $this->field29 = $field29;

        return $this;
    }

    /**
     * Get field29
     *
     * @return string
     */
    public function getField29()
    {
        return $this->field29;
    }

    /**
     * Set field30
     *
     * @param  string          $field30
     * @return VBulletinThread
     */
    public function setField30($field30)
    {
        $this->field30 = $field30;

        return $this;
    }

    /**
     * Get field30
     *
     * @return string
     */
    public function getField30()
    {
        return $this->field30;
    }

    /**
     * Set field31
     *
     * @param  string          $field31
     * @return VBulletinThread
     */
    public function setField31($field31)
    {
        $this->field31 = $field31;

        return $this;
    }

    /**
     * Get field31
     *
     * @return string
     */
    public function getField31()
    {
        return $this->field31;
    }

    /**
     * Set field32
     *
     * @param  string          $field32
     * @return VBulletinThread
     */
    public function setField32($field32)
    {
        $this->field32 = $field32;

        return $this;
    }

    /**
     * Get field32
     *
     * @return string
     */
    public function getField32()
    {
        return $this->field32;
    }

    /**
     * Set field33
     *
     * @param  string          $field33
     * @return VBulletinThread
     */
    public function setField33($field33)
    {
        $this->field33 = $field33;

        return $this;
    }

    /**
     * Get field33
     *
     * @return string
     */
    public function getField33()
    {
        return $this->field33;
    }

    /**
     * Set field34
     *
     * @param  string          $field34
     * @return VBulletinThread
     */
    public function setField34($field34)
    {
        $this->field34 = $field34;

        return $this;
    }

    /**
     * Get field34
     *
     * @return string
     */
    public function getField34()
    {
        return $this->field34;
    }

    /**
     * Set field35
     *
     * @param  string          $field35
     * @return VBulletinThread
     */
    public function setField35($field35)
    {
        $this->field35 = $field35;

        return $this;
    }

    /**
     * Get field35
     *
     * @return string
     */
    public function getField35()
    {
        return $this->field35;
    }

    /**
     * Set field36
     *
     * @param  string          $field36
     * @return VBulletinThread
     */
    public function setField36($field36)
    {
        $this->field36 = $field36;

        return $this;
    }

    /**
     * Get field36
     *
     * @return string
     */
    public function getField36()
    {
        return $this->field36;
    }

    /**
     * Set field37
     *
     * @param  string          $field37
     * @return VBulletinThread
     */
    public function setField37($field37)
    {
        $this->field37 = $field37;

        return $this;
    }

    /**
     * Get field37
     *
     * @return string
     */
    public function getField37()
    {
        return $this->field37;
    }

    /**
     * Set tweeted
     *
     * @param  integer         $tweeted
     * @return VBulletinThread
     */
    public function setTweeted($tweeted)
    {
        $this->tweeted = $tweeted;

        return $this;
    }

    /**
     * Get tweeted
     *
     * @return integer
     */
    public function getTweeted()
    {
        return $this->tweeted;
    }

    /**
     * Set tweetScreenName
     *
     * @param  string          $tweetScreenName
     * @return VBulletinThread
     */
    public function setTweetScreenName($tweetScreenName)
    {
        $this->tweetScreenName = $tweetScreenName;

        return $this;
    }

    /**
     * Get tweetScreenName
     *
     * @return string
     */
    public function getTweetScreenName()
    {
        return $this->tweetScreenName;
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
     * Add posts
     *
     * @param  \Rshief\Bundle\MigrationBundle\Entity\VBulletinPost $posts
     * @return VBulletinThread
     */
    public function addPost(\Rshief\Bundle\MigrationBundle\Entity\VBulletinPost $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Rshief\Bundle\MigrationBundle\Entity\VBulletinPost $posts
     */
    public function removePost(\Rshief\Bundle\MigrationBundle\Entity\VBulletinPost $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set forum
     *
     * @param  \Rshief\Bundle\MigrationBundle\Entity\VBulletinForum $forum
     * @return VBulletinThread
     */
    public function setForum(\Rshief\Bundle\MigrationBundle\Entity\VBulletinForum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get forum
     *
     * @return \Rshief\Bundle\MigrationBundle\Entity\VBulletinForum
     */
    public function getForum()
    {
        return $this->forum;
    }
}
