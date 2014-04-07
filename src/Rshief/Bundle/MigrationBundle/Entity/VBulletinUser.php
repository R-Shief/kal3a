<?php

namespace Rshief\Bundle\MigrationBundle\Entity;

/**
 * VBulletinUser
 */
class VBulletinUser
{
    /**
     * @var integer
     */
    private $usergroupid;

    /**
     * @var string
     */
    private $membergroupids;

    /**
     * @var integer
     */
    private $displaygroupid;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $passworddate;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $styleid;

    /**
     * @var string
     */
    private $parentemail;

    /**
     * @var string
     */
    private $homepage;

    /**
     * @var string
     */
    private $icq;

    /**
     * @var string
     */
    private $aim;

    /**
     * @var string
     */
    private $yahoo;

    /**
     * @var string
     */
    private $msn;

    /**
     * @var string
     */
    private $skype;

    /**
     * @var integer
     */
    private $showvbcode;

    /**
     * @var integer
     */
    private $showbirthday;

    /**
     * @var string
     */
    private $usertitle;

    /**
     * @var integer
     */
    private $customtitle;

    /**
     * @var integer
     */
    private $joindate;

    /**
     * @var integer
     */
    private $daysprune;

    /**
     * @var integer
     */
    private $lastvisit;

    /**
     * @var integer
     */
    private $lastactivity;

    /**
     * @var integer
     */
    private $lastpost;

    /**
     * @var integer
     */
    private $lastpostid;

    /**
     * @var integer
     */
    private $posts;

    /**
     * @var integer
     */
    private $reputation;

    /**
     * @var integer
     */
    private $reputationlevelid;

    /**
     * @var string
     */
    private $timezoneoffset;

    /**
     * @var integer
     */
    private $pmpopup;

    /**
     * @var integer
     */
    private $avatarid;

    /**
     * @var integer
     */
    private $avatarrevision;

    /**
     * @var integer
     */
    private $profilepicrevision;

    /**
     * @var integer
     */
    private $sigpicrevision;

    /**
     * @var integer
     */
    private $options;

    /**
     * @var integer
     */
    private $akvbghsfsOptionsfield;

    /**
     * @var string
     */
    private $birthday;

    /**
     * @var \DateTime
     */
    private $birthdaySearch;

    /**
     * @var integer
     */
    private $maxposts;

    /**
     * @var integer
     */
    private $startofweek;

    /**
     * @var string
     */
    private $ipaddress;

    /**
     * @var integer
     */
    private $referrerid;

    /**
     * @var integer
     */
    private $languageid;

    /**
     * @var integer
     */
    private $emailstamp;

    /**
     * @var integer
     */
    private $threadedmode;

    /**
     * @var integer
     */
    private $autosubscribe;

    /**
     * @var integer
     */
    private $pmtotal;

    /**
     * @var integer
     */
    private $pmunread;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var integer
     */
    private $ipoints;

    /**
     * @var integer
     */
    private $infractions;

    /**
     * @var integer
     */
    private $warnings;

    /**
     * @var string
     */
    private $infractiongroupids;

    /**
     * @var integer
     */
    private $infractiongroupid;

    /**
     * @var integer
     */
    private $adminoptions;

    /**
     * @var integer
     */
    private $profilevisits;

    /**
     * @var integer
     */
    private $friendcount;

    /**
     * @var integer
     */
    private $friendreqcount;

    /**
     * @var integer
     */
    private $vmunreadcount;

    /**
     * @var integer
     */
    private $vmmoderatedcount;

    /**
     * @var integer
     */
    private $socgroupinvitecount;

    /**
     * @var integer
     */
    private $socgroupreqcount;

    /**
     * @var integer
     */
    private $pcunreadcount;

    /**
     * @var integer
     */
    private $pcmoderatedcount;

    /**
     * @var integer
     */
    private $gmmoderatedcount;

    /**
     * @var integer
     */
    private $vbseoLikesIn;

    /**
     * @var integer
     */
    private $vbseoLikesOut;

    /**
     * @var integer
     */
    private $vbseoLikesUnread;

    /**
     * @var string
     */
    private $ncodeImageresizerMode;

    /**
     * @var integer
     */
    private $ncodeImageresizerMaxwidth;

    /**
     * @var integer
     */
    private $ncodeImageresizerMaxheight;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $thePosts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->thePosts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set usergroupid
     *
     * @param  integer       $usergroupid
     * @return VBulletinUser
     */
    public function setUsergroupid($usergroupid)
    {
        $this->usergroupid = $usergroupid;

        return $this;
    }

    /**
     * Get usergroupid
     *
     * @return integer
     */
    public function getUsergroupid()
    {
        return $this->usergroupid;
    }

    /**
     * Set membergroupids
     *
     * @param  string        $membergroupids
     * @return VBulletinUser
     */
    public function setMembergroupids($membergroupids)
    {
        $this->membergroupids = $membergroupids;

        return $this;
    }

    /**
     * Get membergroupids
     *
     * @return string
     */
    public function getMembergroupids()
    {
        return $this->membergroupids;
    }

    /**
     * Set displaygroupid
     *
     * @param  integer       $displaygroupid
     * @return VBulletinUser
     */
    public function setDisplaygroupid($displaygroupid)
    {
        $this->displaygroupid = $displaygroupid;

        return $this;
    }

    /**
     * Get displaygroupid
     *
     * @return integer
     */
    public function getDisplaygroupid()
    {
        return $this->displaygroupid;
    }

    /**
     * Set username
     *
     * @param  string        $username
     * @return VBulletinUser
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
     * Set password
     *
     * @param  string        $password
     * @return VBulletinUser
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
     * Set passworddate
     *
     * @param  \DateTime     $passworddate
     * @return VBulletinUser
     */
    public function setPassworddate($passworddate)
    {
        $this->passworddate = $passworddate;

        return $this;
    }

    /**
     * Get passworddate
     *
     * @return \DateTime
     */
    public function getPassworddate()
    {
        return $this->passworddate;
    }

    /**
     * Set email
     *
     * @param  string        $email
     * @return VBulletinUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set styleid
     *
     * @param  integer       $styleid
     * @return VBulletinUser
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
     * Set parentemail
     *
     * @param  string        $parentemail
     * @return VBulletinUser
     */
    public function setParentemail($parentemail)
    {
        $this->parentemail = $parentemail;

        return $this;
    }

    /**
     * Get parentemail
     *
     * @return string
     */
    public function getParentemail()
    {
        return $this->parentemail;
    }

    /**
     * Set homepage
     *
     * @param  string        $homepage
     * @return VBulletinUser
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Set icq
     *
     * @param  string        $icq
     * @return VBulletinUser
     */
    public function setIcq($icq)
    {
        $this->icq = $icq;

        return $this;
    }

    /**
     * Get icq
     *
     * @return string
     */
    public function getIcq()
    {
        return $this->icq;
    }

    /**
     * Set aim
     *
     * @param  string        $aim
     * @return VBulletinUser
     */
    public function setAim($aim)
    {
        $this->aim = $aim;

        return $this;
    }

    /**
     * Get aim
     *
     * @return string
     */
    public function getAim()
    {
        return $this->aim;
    }

    /**
     * Set yahoo
     *
     * @param  string        $yahoo
     * @return VBulletinUser
     */
    public function setYahoo($yahoo)
    {
        $this->yahoo = $yahoo;

        return $this;
    }

    /**
     * Get yahoo
     *
     * @return string
     */
    public function getYahoo()
    {
        return $this->yahoo;
    }

    /**
     * Set msn
     *
     * @param  string        $msn
     * @return VBulletinUser
     */
    public function setMsn($msn)
    {
        $this->msn = $msn;

        return $this;
    }

    /**
     * Get msn
     *
     * @return string
     */
    public function getMsn()
    {
        return $this->msn;
    }

    /**
     * Set skype
     *
     * @param  string        $skype
     * @return VBulletinUser
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set showvbcode
     *
     * @param  integer       $showvbcode
     * @return VBulletinUser
     */
    public function setShowvbcode($showvbcode)
    {
        $this->showvbcode = $showvbcode;

        return $this;
    }

    /**
     * Get showvbcode
     *
     * @return integer
     */
    public function getShowvbcode()
    {
        return $this->showvbcode;
    }

    /**
     * Set showbirthday
     *
     * @param  integer       $showbirthday
     * @return VBulletinUser
     */
    public function setShowbirthday($showbirthday)
    {
        $this->showbirthday = $showbirthday;

        return $this;
    }

    /**
     * Get showbirthday
     *
     * @return integer
     */
    public function getShowbirthday()
    {
        return $this->showbirthday;
    }

    /**
     * Set usertitle
     *
     * @param  string        $usertitle
     * @return VBulletinUser
     */
    public function setUsertitle($usertitle)
    {
        $this->usertitle = $usertitle;

        return $this;
    }

    /**
     * Get usertitle
     *
     * @return string
     */
    public function getUsertitle()
    {
        return $this->usertitle;
    }

    /**
     * Set customtitle
     *
     * @param  integer       $customtitle
     * @return VBulletinUser
     */
    public function setCustomtitle($customtitle)
    {
        $this->customtitle = $customtitle;

        return $this;
    }

    /**
     * Get customtitle
     *
     * @return integer
     */
    public function getCustomtitle()
    {
        return $this->customtitle;
    }

    /**
     * Set joindate
     *
     * @param  integer       $joindate
     * @return VBulletinUser
     */
    public function setJoindate($joindate)
    {
        $this->joindate = $joindate;

        return $this;
    }

    /**
     * Get joindate
     *
     * @return integer
     */
    public function getJoindate()
    {
        return $this->joindate;
    }

    /**
     * Set daysprune
     *
     * @param  integer       $daysprune
     * @return VBulletinUser
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
     * Set lastvisit
     *
     * @param  integer       $lastvisit
     * @return VBulletinUser
     */
    public function setLastvisit($lastvisit)
    {
        $this->lastvisit = $lastvisit;

        return $this;
    }

    /**
     * Get lastvisit
     *
     * @return integer
     */
    public function getLastvisit()
    {
        return $this->lastvisit;
    }

    /**
     * Set lastactivity
     *
     * @param  integer       $lastactivity
     * @return VBulletinUser
     */
    public function setLastactivity($lastactivity)
    {
        $this->lastactivity = $lastactivity;

        return $this;
    }

    /**
     * Get lastactivity
     *
     * @return integer
     */
    public function getLastactivity()
    {
        return $this->lastactivity;
    }

    /**
     * Set lastpost
     *
     * @param  integer       $lastpost
     * @return VBulletinUser
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
     * Set lastpostid
     *
     * @param  integer       $lastpostid
     * @return VBulletinUser
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
     * Set posts
     *
     * @param  integer       $posts
     * @return VBulletinUser
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;

        return $this;
    }

    /**
     * Get posts
     *
     * @return integer
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set reputation
     *
     * @param  integer       $reputation
     * @return VBulletinUser
     */
    public function setReputation($reputation)
    {
        $this->reputation = $reputation;

        return $this;
    }

    /**
     * Get reputation
     *
     * @return integer
     */
    public function getReputation()
    {
        return $this->reputation;
    }

    /**
     * Set reputationlevelid
     *
     * @param  integer       $reputationlevelid
     * @return VBulletinUser
     */
    public function setReputationlevelid($reputationlevelid)
    {
        $this->reputationlevelid = $reputationlevelid;

        return $this;
    }

    /**
     * Get reputationlevelid
     *
     * @return integer
     */
    public function getReputationlevelid()
    {
        return $this->reputationlevelid;
    }

    /**
     * Set timezoneoffset
     *
     * @param  string        $timezoneoffset
     * @return VBulletinUser
     */
    public function setTimezoneoffset($timezoneoffset)
    {
        $this->timezoneoffset = $timezoneoffset;

        return $this;
    }

    /**
     * Get timezoneoffset
     *
     * @return string
     */
    public function getTimezoneoffset()
    {
        return $this->timezoneoffset;
    }

    /**
     * Set pmpopup
     *
     * @param  integer       $pmpopup
     * @return VBulletinUser
     */
    public function setPmpopup($pmpopup)
    {
        $this->pmpopup = $pmpopup;

        return $this;
    }

    /**
     * Get pmpopup
     *
     * @return integer
     */
    public function getPmpopup()
    {
        return $this->pmpopup;
    }

    /**
     * Set avatarid
     *
     * @param  integer       $avatarid
     * @return VBulletinUser
     */
    public function setAvatarid($avatarid)
    {
        $this->avatarid = $avatarid;

        return $this;
    }

    /**
     * Get avatarid
     *
     * @return integer
     */
    public function getAvatarid()
    {
        return $this->avatarid;
    }

    /**
     * Set avatarrevision
     *
     * @param  integer       $avatarrevision
     * @return VBulletinUser
     */
    public function setAvatarrevision($avatarrevision)
    {
        $this->avatarrevision = $avatarrevision;

        return $this;
    }

    /**
     * Get avatarrevision
     *
     * @return integer
     */
    public function getAvatarrevision()
    {
        return $this->avatarrevision;
    }

    /**
     * Set profilepicrevision
     *
     * @param  integer       $profilepicrevision
     * @return VBulletinUser
     */
    public function setProfilepicrevision($profilepicrevision)
    {
        $this->profilepicrevision = $profilepicrevision;

        return $this;
    }

    /**
     * Get profilepicrevision
     *
     * @return integer
     */
    public function getProfilepicrevision()
    {
        return $this->profilepicrevision;
    }

    /**
     * Set sigpicrevision
     *
     * @param  integer       $sigpicrevision
     * @return VBulletinUser
     */
    public function setSigpicrevision($sigpicrevision)
    {
        $this->sigpicrevision = $sigpicrevision;

        return $this;
    }

    /**
     * Get sigpicrevision
     *
     * @return integer
     */
    public function getSigpicrevision()
    {
        return $this->sigpicrevision;
    }

    /**
     * Set options
     *
     * @param  integer       $options
     * @return VBulletinUser
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
     * Set akvbghsfsOptionsfield
     *
     * @param  integer       $akvbghsfsOptionsfield
     * @return VBulletinUser
     */
    public function setAkvbghsfsOptionsfield($akvbghsfsOptionsfield)
    {
        $this->akvbghsfsOptionsfield = $akvbghsfsOptionsfield;

        return $this;
    }

    /**
     * Get akvbghsfsOptionsfield
     *
     * @return integer
     */
    public function getAkvbghsfsOptionsfield()
    {
        return $this->akvbghsfsOptionsfield;
    }

    /**
     * Set birthday
     *
     * @param  string        $birthday
     * @return VBulletinUser
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set birthdaySearch
     *
     * @param  \DateTime     $birthdaySearch
     * @return VBulletinUser
     */
    public function setBirthdaySearch($birthdaySearch)
    {
        $this->birthdaySearch = $birthdaySearch;

        return $this;
    }

    /**
     * Get birthdaySearch
     *
     * @return \DateTime
     */
    public function getBirthdaySearch()
    {
        return $this->birthdaySearch;
    }

    /**
     * Set maxposts
     *
     * @param  integer       $maxposts
     * @return VBulletinUser
     */
    public function setMaxposts($maxposts)
    {
        $this->maxposts = $maxposts;

        return $this;
    }

    /**
     * Get maxposts
     *
     * @return integer
     */
    public function getMaxposts()
    {
        return $this->maxposts;
    }

    /**
     * Set startofweek
     *
     * @param  integer       $startofweek
     * @return VBulletinUser
     */
    public function setStartofweek($startofweek)
    {
        $this->startofweek = $startofweek;

        return $this;
    }

    /**
     * Get startofweek
     *
     * @return integer
     */
    public function getStartofweek()
    {
        return $this->startofweek;
    }

    /**
     * Set ipaddress
     *
     * @param  string        $ipaddress
     * @return VBulletinUser
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
     * Set referrerid
     *
     * @param  integer       $referrerid
     * @return VBulletinUser
     */
    public function setReferrerid($referrerid)
    {
        $this->referrerid = $referrerid;

        return $this;
    }

    /**
     * Get referrerid
     *
     * @return integer
     */
    public function getReferrerid()
    {
        return $this->referrerid;
    }

    /**
     * Set languageid
     *
     * @param  integer       $languageid
     * @return VBulletinUser
     */
    public function setLanguageid($languageid)
    {
        $this->languageid = $languageid;

        return $this;
    }

    /**
     * Get languageid
     *
     * @return integer
     */
    public function getLanguageid()
    {
        return $this->languageid;
    }

    /**
     * Set emailstamp
     *
     * @param  integer       $emailstamp
     * @return VBulletinUser
     */
    public function setEmailstamp($emailstamp)
    {
        $this->emailstamp = $emailstamp;

        return $this;
    }

    /**
     * Get emailstamp
     *
     * @return integer
     */
    public function getEmailstamp()
    {
        return $this->emailstamp;
    }

    /**
     * Set threadedmode
     *
     * @param  integer       $threadedmode
     * @return VBulletinUser
     */
    public function setThreadedmode($threadedmode)
    {
        $this->threadedmode = $threadedmode;

        return $this;
    }

    /**
     * Get threadedmode
     *
     * @return integer
     */
    public function getThreadedmode()
    {
        return $this->threadedmode;
    }

    /**
     * Set autosubscribe
     *
     * @param  integer       $autosubscribe
     * @return VBulletinUser
     */
    public function setAutosubscribe($autosubscribe)
    {
        $this->autosubscribe = $autosubscribe;

        return $this;
    }

    /**
     * Get autosubscribe
     *
     * @return integer
     */
    public function getAutosubscribe()
    {
        return $this->autosubscribe;
    }

    /**
     * Set pmtotal
     *
     * @param  integer       $pmtotal
     * @return VBulletinUser
     */
    public function setPmtotal($pmtotal)
    {
        $this->pmtotal = $pmtotal;

        return $this;
    }

    /**
     * Get pmtotal
     *
     * @return integer
     */
    public function getPmtotal()
    {
        return $this->pmtotal;
    }

    /**
     * Set pmunread
     *
     * @param  integer       $pmunread
     * @return VBulletinUser
     */
    public function setPmunread($pmunread)
    {
        $this->pmunread = $pmunread;

        return $this;
    }

    /**
     * Get pmunread
     *
     * @return integer
     */
    public function getPmunread()
    {
        return $this->pmunread;
    }

    /**
     * Set salt
     *
     * @param  string        $salt
     * @return VBulletinUser
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set ipoints
     *
     * @param  integer       $ipoints
     * @return VBulletinUser
     */
    public function setIpoints($ipoints)
    {
        $this->ipoints = $ipoints;

        return $this;
    }

    /**
     * Get ipoints
     *
     * @return integer
     */
    public function getIpoints()
    {
        return $this->ipoints;
    }

    /**
     * Set infractions
     *
     * @param  integer       $infractions
     * @return VBulletinUser
     */
    public function setInfractions($infractions)
    {
        $this->infractions = $infractions;

        return $this;
    }

    /**
     * Get infractions
     *
     * @return integer
     */
    public function getInfractions()
    {
        return $this->infractions;
    }

    /**
     * Set warnings
     *
     * @param  integer       $warnings
     * @return VBulletinUser
     */
    public function setWarnings($warnings)
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * Get warnings
     *
     * @return integer
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * Set infractiongroupids
     *
     * @param  string        $infractiongroupids
     * @return VBulletinUser
     */
    public function setInfractiongroupids($infractiongroupids)
    {
        $this->infractiongroupids = $infractiongroupids;

        return $this;
    }

    /**
     * Get infractiongroupids
     *
     * @return string
     */
    public function getInfractiongroupids()
    {
        return $this->infractiongroupids;
    }

    /**
     * Set infractiongroupid
     *
     * @param  integer       $infractiongroupid
     * @return VBulletinUser
     */
    public function setInfractiongroupid($infractiongroupid)
    {
        $this->infractiongroupid = $infractiongroupid;

        return $this;
    }

    /**
     * Get infractiongroupid
     *
     * @return integer
     */
    public function getInfractiongroupid()
    {
        return $this->infractiongroupid;
    }

    /**
     * Set adminoptions
     *
     * @param  integer       $adminoptions
     * @return VBulletinUser
     */
    public function setAdminoptions($adminoptions)
    {
        $this->adminoptions = $adminoptions;

        return $this;
    }

    /**
     * Get adminoptions
     *
     * @return integer
     */
    public function getAdminoptions()
    {
        return $this->adminoptions;
    }

    /**
     * Set profilevisits
     *
     * @param  integer       $profilevisits
     * @return VBulletinUser
     */
    public function setProfilevisits($profilevisits)
    {
        $this->profilevisits = $profilevisits;

        return $this;
    }

    /**
     * Get profilevisits
     *
     * @return integer
     */
    public function getProfilevisits()
    {
        return $this->profilevisits;
    }

    /**
     * Set friendcount
     *
     * @param  integer       $friendcount
     * @return VBulletinUser
     */
    public function setFriendcount($friendcount)
    {
        $this->friendcount = $friendcount;

        return $this;
    }

    /**
     * Get friendcount
     *
     * @return integer
     */
    public function getFriendcount()
    {
        return $this->friendcount;
    }

    /**
     * Set friendreqcount
     *
     * @param  integer       $friendreqcount
     * @return VBulletinUser
     */
    public function setFriendreqcount($friendreqcount)
    {
        $this->friendreqcount = $friendreqcount;

        return $this;
    }

    /**
     * Get friendreqcount
     *
     * @return integer
     */
    public function getFriendreqcount()
    {
        return $this->friendreqcount;
    }

    /**
     * Set vmunreadcount
     *
     * @param  integer       $vmunreadcount
     * @return VBulletinUser
     */
    public function setVmunreadcount($vmunreadcount)
    {
        $this->vmunreadcount = $vmunreadcount;

        return $this;
    }

    /**
     * Get vmunreadcount
     *
     * @return integer
     */
    public function getVmunreadcount()
    {
        return $this->vmunreadcount;
    }

    /**
     * Set vmmoderatedcount
     *
     * @param  integer       $vmmoderatedcount
     * @return VBulletinUser
     */
    public function setVmmoderatedcount($vmmoderatedcount)
    {
        $this->vmmoderatedcount = $vmmoderatedcount;

        return $this;
    }

    /**
     * Get vmmoderatedcount
     *
     * @return integer
     */
    public function getVmmoderatedcount()
    {
        return $this->vmmoderatedcount;
    }

    /**
     * Set socgroupinvitecount
     *
     * @param  integer       $socgroupinvitecount
     * @return VBulletinUser
     */
    public function setSocgroupinvitecount($socgroupinvitecount)
    {
        $this->socgroupinvitecount = $socgroupinvitecount;

        return $this;
    }

    /**
     * Get socgroupinvitecount
     *
     * @return integer
     */
    public function getSocgroupinvitecount()
    {
        return $this->socgroupinvitecount;
    }

    /**
     * Set socgroupreqcount
     *
     * @param  integer       $socgroupreqcount
     * @return VBulletinUser
     */
    public function setSocgroupreqcount($socgroupreqcount)
    {
        $this->socgroupreqcount = $socgroupreqcount;

        return $this;
    }

    /**
     * Get socgroupreqcount
     *
     * @return integer
     */
    public function getSocgroupreqcount()
    {
        return $this->socgroupreqcount;
    }

    /**
     * Set pcunreadcount
     *
     * @param  integer       $pcunreadcount
     * @return VBulletinUser
     */
    public function setPcunreadcount($pcunreadcount)
    {
        $this->pcunreadcount = $pcunreadcount;

        return $this;
    }

    /**
     * Get pcunreadcount
     *
     * @return integer
     */
    public function getPcunreadcount()
    {
        return $this->pcunreadcount;
    }

    /**
     * Set pcmoderatedcount
     *
     * @param  integer       $pcmoderatedcount
     * @return VBulletinUser
     */
    public function setPcmoderatedcount($pcmoderatedcount)
    {
        $this->pcmoderatedcount = $pcmoderatedcount;

        return $this;
    }

    /**
     * Get pcmoderatedcount
     *
     * @return integer
     */
    public function getPcmoderatedcount()
    {
        return $this->pcmoderatedcount;
    }

    /**
     * Set gmmoderatedcount
     *
     * @param  integer       $gmmoderatedcount
     * @return VBulletinUser
     */
    public function setGmmoderatedcount($gmmoderatedcount)
    {
        $this->gmmoderatedcount = $gmmoderatedcount;

        return $this;
    }

    /**
     * Get gmmoderatedcount
     *
     * @return integer
     */
    public function getGmmoderatedcount()
    {
        return $this->gmmoderatedcount;
    }

    /**
     * Set vbseoLikesIn
     *
     * @param  integer       $vbseoLikesIn
     * @return VBulletinUser
     */
    public function setVbseoLikesIn($vbseoLikesIn)
    {
        $this->vbseoLikesIn = $vbseoLikesIn;

        return $this;
    }

    /**
     * Get vbseoLikesIn
     *
     * @return integer
     */
    public function getVbseoLikesIn()
    {
        return $this->vbseoLikesIn;
    }

    /**
     * Set vbseoLikesOut
     *
     * @param  integer       $vbseoLikesOut
     * @return VBulletinUser
     */
    public function setVbseoLikesOut($vbseoLikesOut)
    {
        $this->vbseoLikesOut = $vbseoLikesOut;

        return $this;
    }

    /**
     * Get vbseoLikesOut
     *
     * @return integer
     */
    public function getVbseoLikesOut()
    {
        return $this->vbseoLikesOut;
    }

    /**
     * Set vbseoLikesUnread
     *
     * @param  integer       $vbseoLikesUnread
     * @return VBulletinUser
     */
    public function setVbseoLikesUnread($vbseoLikesUnread)
    {
        $this->vbseoLikesUnread = $vbseoLikesUnread;

        return $this;
    }

    /**
     * Get vbseoLikesUnread
     *
     * @return integer
     */
    public function getVbseoLikesUnread()
    {
        return $this->vbseoLikesUnread;
    }

    /**
     * Set ncodeImageresizerMode
     *
     * @param  string        $ncodeImageresizerMode
     * @return VBulletinUser
     */
    public function setNcodeImageresizerMode($ncodeImageresizerMode)
    {
        $this->ncodeImageresizerMode = $ncodeImageresizerMode;

        return $this;
    }

    /**
     * Get ncodeImageresizerMode
     *
     * @return string
     */
    public function getNcodeImageresizerMode()
    {
        return $this->ncodeImageresizerMode;
    }

    /**
     * Set ncodeImageresizerMaxwidth
     *
     * @param  integer       $ncodeImageresizerMaxwidth
     * @return VBulletinUser
     */
    public function setNcodeImageresizerMaxwidth($ncodeImageresizerMaxwidth)
    {
        $this->ncodeImageresizerMaxwidth = $ncodeImageresizerMaxwidth;

        return $this;
    }

    /**
     * Get ncodeImageresizerMaxwidth
     *
     * @return integer
     */
    public function getNcodeImageresizerMaxwidth()
    {
        return $this->ncodeImageresizerMaxwidth;
    }

    /**
     * Set ncodeImageresizerMaxheight
     *
     * @param  integer       $ncodeImageresizerMaxheight
     * @return VBulletinUser
     */
    public function setNcodeImageresizerMaxheight($ncodeImageresizerMaxheight)
    {
        $this->ncodeImageresizerMaxheight = $ncodeImageresizerMaxheight;

        return $this;
    }

    /**
     * Get ncodeImageresizerMaxheight
     *
     * @return integer
     */
    public function getNcodeImageresizerMaxheight()
    {
        return $this->ncodeImageresizerMaxheight;
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
     * Add thePosts
     *
     * @param  \Rshief\Bundle\MigrationBundle\Entity\VBulletinPost $thePosts
     * @return VBulletinUser
     */
    public function addThePost(\Rshief\Bundle\MigrationBundle\Entity\VBulletinPost $thePosts)
    {
        $this->thePosts[] = $thePosts;

        return $this;
    }

    /**
     * Remove thePosts
     *
     * @param \Rshief\Bundle\MigrationBundle\Entity\VBulletinPost $thePosts
     */
    public function removeThePost(\Rshief\Bundle\MigrationBundle\Entity\VBulletinPost $thePosts)
    {
        $this->thePosts->removeElement($thePosts);
    }

    /**
     * Get thePosts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThePosts()
    {
        return $this->thePosts;
    }
}
