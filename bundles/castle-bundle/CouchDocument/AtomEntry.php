<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\EntryType;
use Doctrine\Common\Collections\Collection;
use Doctrine\CouchDB\Attachment;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class AtomEntry.
 *
 * @ODM\Document
 */
abstract class AtomEntry extends EntryType
{
    /** @var array<Attachment> $attachments */
    protected $attachments = array();

    /**  @var array */
    protected $extra = array();

    /**
     * Add attachment.
     *
     * @param $filename
     * @param Attachment $attachment
     *
     * @return AtomEntry
     */
    public function setAttachment($filename, Attachment $attachment)
    {
        $this->attachments[$filename] = $attachment;

        return $this;
    }

    /**
     * Remove attachment.
     *
     * @param $filename
     * @param Attachment $attachment
     */
    public function removeAttachment($filename, Attachment $attachment)
    {
        unset($this->attachments[$filename]);
    }

    /**
     * Get attachments.
     *
     * @return Collection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Set attachments.
     *
     * @param Collection $attachments
     *
     * @return AtomEntry
     */
    public function setAttachments(Collection $attachments)
    {
        $this->attachments = $attachments;

        return $this;
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
