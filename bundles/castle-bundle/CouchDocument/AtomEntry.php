<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\EntryType;
use Doctrine\Common\Collections\Collection;
use Doctrine\CouchDB\Attachment;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class AtomEntry
 * @package Bangpound\Bundle\CastleBundle\CouchDocument
 * @ODM\Document
 */
abstract class AtomEntry extends EntryType
{
    /** @var array<Attachment> $attachments */
    protected $attachments;

    /**  @var array */
    protected $extra;

    /**
     *
     */
    public function __construct()
    {
        $this->attachments = array();
        $this->extra = array();
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

    public function setOriginalData($data, $type)
    {
        $attachment = Attachment::createFromBinaryData($data, $type);

        return $this->setAttachment('original', $attachment);
    }

    public function getExtra($key)
    {
        return $this->extra[$key];
    }

    public function setExtra($key, $value)
    {
        $this->extra[$key] = $value;

        return $this;
    }
}
