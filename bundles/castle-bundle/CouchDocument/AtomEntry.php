<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\EntryType;
use Doctrine\CouchDB\Attachment;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * Class AtomEntry.
 *
 * @ODM\Document
 * @ES\Document(type="atom")
 */
class AtomEntry extends EntryType
{
    use CommonTypes;

    /**
     * @var int
     * @ES\Id()
     */
    protected $id;

    /**
     * @var ContentType
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\ContentType")
     */
    protected $content;

    /**
     * @var \DateTime (atom:dateTimeType)
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     */
    protected $published;

    /**
     * @var TextType
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\TextType")
     */
    protected $rights;

    /**
     * @var SourceType
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\SourceType")
     */
    protected $source;

    /**
     * @var TextType
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\TextType")
     */
    protected $summary;

    /**
     * @var TextType
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\TextType")
     */
    protected $title;

    /**
     * @var \DateTime (atom:dateTimeType)
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     */
    protected $updated;

    /** @var array<Attachment> $attachments */
    protected $attachments = array();

    /** @var array */
    protected $extra = array();

    public function __construct()
    {
        $this->authors = new Collection();
        $this->categories = new Collection();
        $this->contributors = new Collection();
        $this->links = new Collection();
    }

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
