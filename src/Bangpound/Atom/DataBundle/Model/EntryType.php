<?php
/**
 * PHP classes for atom.xsd.xml
 *
 *
 *
 * This version of the Atom schema is based on version 1.0 of the format specifications,
 *
 * found here http://www.atomenabled.org/developers/syndication/atom-format-spec.php.
 *
 *
 *
 *
 *
 * An Atom document may have two root elements, feed and entry, as defined in section 2.
 *
 *
 *
 * PHP Version 5.3
 *
 * @category DTOs
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */

namespace Bangpound\Atom\DataBundle\Model;

use Bangpound\Atom\DataBundle\Model\SourceType;
use Bangpound\Atom\DataBundle\Model\TextType;
use Bangpound\Atom\DataBundle\Model\ContentType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\CouchDB\Types\DateTimeType;

/**
 * EntryType
 *
 * The Atom entry construct is defined in section 4.1.2 of the format spec.
 *
 * @category DTOs
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */
abstract class EntryType extends CommonAttributes
{
    use CommonTypes;

    /**
     * @var PersonType (atom:personType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $authors;

    /**
     * @var CategoryType (atom:categoryType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $categories;

    /**
     * @var PersonType (atom:personType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $contributors;

    /**
     * @var LinkType (atom:linksType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $links;

    /**
     * @var ContentType $content
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $content;

    /**
     * @var string (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $id;

    /**
     * @var \DateTime (atom:dateTimeType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $published;

    /**
     * @var TextType $rights
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $rights;

    /**
     * @var SourceType
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $source;

    /**
     * @var TextType $summary
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $summary;

    /**
     * @var TextType $title
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $title;

    /**
     * @var \DateTime (atom:dateTimeType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $updated;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->contributors = new ArrayCollection();
        $this->links = new ArrayCollection();
    }

    /**
     * @return ContentType
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param ContentType $content
     */
    public function setContent($content)
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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return TextType
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param TextType $summary
     */
    public function setSummary(TextType $summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return \DateTime
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param \DateTime $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * @return TextType
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param TextType $rights
     */
    public function setRights(TextType $rights)
    {
        $this->rights = $rights;
    }

    /**
     * @return SourceType
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param SourceType $source
     */
    public function setSource(SourceType $source)
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
     * @param string $title
     */
    public function setTitle(TextType $title)
    {
        $this->title = $title;
    }
}
