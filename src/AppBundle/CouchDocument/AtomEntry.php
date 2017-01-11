<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations as App;
use AppBundle\Entity\StreamParameters;
use Bangpound\Atom\Model\ContentTypeInterface;
use Bangpound\Atom\Model\EntryTypeInterface;
use Bangpound\Atom\Model\SourceTypeInterface;
use Bangpound\Atom\Model\TextTypeInterface;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class AtomEntry.
 *
 * @ODM\Document(type="atom")
 */
class AtomEntry extends CommonTypes implements EntryTypeInterface
{
    /**
     * @var string
     * @ODM\Id()
     * @App\PropertyInfoType("string")
     */
    protected $_id;

    /**
     * @var string
     * @ODM\Version()
     * @App\PropertyInfoType("string")
     */
    protected $_rev;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $id;

    /**
     * @var ContentType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\ContentType", nullable=true)
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="datetime")
     * @App\PropertyInfoType("object", class="DateTime", nullable=true)
     */
    protected $published;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $rights;

    /**
     * @var SourceType
     *
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\SourceType", nullable=true)
     */
    protected $source;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $summary;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="datetime")
     * @App\PropertyInfoType("object", class="DateTime", nullable=true)
     */
    protected $updated;


    /**
     * @var string[]
     * @ODM\Field()
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
