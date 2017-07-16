<?php

namespace AppBundle\Document;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\ContentTypeInterface;
use Bangpound\Atom\Model\EntryTypeInterface;
use Bangpound\Atom\Model\SourceTypeInterface;
use Bangpound\Atom\Model\TextTypeInterface;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * Class AtomEntry.
 *
 * @ES\Document(type="atom")
 */
class AtomEntry extends CommonTypes implements EntryTypeInterface
{
    public function __construct()
    {
        $this->authors = new Collection();
        $this->categories = new Collection();
        $this->contributors = new Collection();
        $this->links = new Collection();
    }

    /**
     * @var string
     * @ES\Id()
     * @App\PropertyInfoType("string")
     */
    protected $id;

    /**
     * @var ContentType
     * @ES\Embedded(class="AppBundle\Document\ContentType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\ContentType", nullable=true)
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     * @App\PropertyInfoType("object", class="DateTime", nullable=true)
     */
    protected $published;

    /**
     * @var TextType
     * @ES\Embedded(class="AppBundle\Document\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\TextType", nullable=true)
     */
    protected $rights;

    /**
     * @var SourceType
     *
     * @ES\Embedded(class="AppBundle\Document\SourceType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\SourceType", nullable=true)
     */
    protected $source;

    /**
     * @var TextType
     * @ES\Embedded(class="AppBundle\Document\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\TextType", nullable=true)
     */
    protected $summary;

    /**
     * @var TextType
     * @ES\Embedded(class="AppBundle\Document\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\TextType", nullable=true)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     * @App\PropertyInfoType("object", class="DateTime", nullable=true)
     */
    protected $updated;


    /**
     * @var string[]
     * @ES\Property(
     *   type="text",
     *   options={
     *     "fields"={
     *       "keyword"={
     *         "type"="keyword"
     *       }
     *     }
     *   }
     * )
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("string", nullable=false))
     */
    protected $parameterNames;

    /**
     * @return ContentTypeInterface
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param ContentTypeInterface $content
     */
    public function setContent(ContentTypeInterface $content = null)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id = null)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTimeInterface $updated
     */
    public function setUpdated(\DateTimeInterface $updated = null)
    {
        $this->updated = $updated;
    }

    /**
     * @return TextTypeInterface
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param TextTypeInterface $summary
     */
    public function setSummary(TextTypeInterface $summary = null)
    {
        $this->summary = $summary;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param \DateTimeInterface $published
     */
    public function setPublished(\DateTimeInterface $published = null)
    {
        $this->published = $published;
    }

    /**
     * @return TextTypeInterface
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param TextTypeInterface $rights
     */
    public function setRights(TextTypeInterface $rights = null)
    {
        $this->rights = $rights;
    }

    /**
     * @return SourceTypeInterface
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param SourceTypeInterface $source
     */
    public function setSource(SourceTypeInterface $source = null)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param TextTypeInterface $title
     */
    public function setTitle(TextTypeInterface $title = null)
    {
        $this->title = $title;
    }

    /**
     * @return \string[]
     */
    public function getParameterNames()
    {
        return $this->parameterNames;
    }

    /**
     * @param \string[] $parameterNames
     */
    public function setParameterNames(array $parameterNames)
    {
        $this->parameterNames = $parameterNames;
    }
}
