<?php

namespace Rshief\PubsubBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\EntryType;
use Doctrine\Common\Collections\Collection;
use Doctrine\CouchDB\Attachment;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class AtomEntry
 * @package Rshief\PubsubBundle\CouchDocument
 * @ODM\Document
 */
class AtomEntry extends EntryType
{
    /** @var array<Attachment> $attachments */
    protected $attachments;

    /**
     *
     */
    public function __construct()
    {
        $this->attachments = array();
    }

    /**
     * Add attachment
     *
     * @param $filename
     * @param  Attachment $attachment
     * @return AtomEntry
     */
    public function setAttachment($filename, Attachment $attachment)
    {
        $this->attachments[$filename] = $attachment;

        return $this;
    }

    /**
     * Remove attachment
     *
     * @param $filename
     * @param Attachment $attachment
     */
    public function removeAttachment($filename, Attachment $attachment)
    {
        unset($this->attachments[$filename]);
    }

    /**
     * Get attachments
     *
     * @return Collection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Set attachments
     *
     * @param  Collection $attachments
     * @return AtomEntry
     */
    public function setAttachments(Collection $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }
}
