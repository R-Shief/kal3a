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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * FeedType
 *
 * The Atom feed construct is defined in section 4.1.1 of the format spec.
 *
 * @category DTOs
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */
abstract class FeedType extends CommonAttributes
{
    use CommonTypes;

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
     * @var GeneratorType (atom:generatorType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $generator;

    /**
     * @var IconType (atom:iconType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $icon;

    /**
     * @var IdType (atom:idType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $id;

    /**
     * @var LogoType (atom:logoType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $logo;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $rights;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $subtitle;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $title;

    /**
     * @var DateTimeType (atom:dateTimeType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $updated;

    /**
     * @var EntryType (atom:entryType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $entries;

    /**
     * @return \Bangpound\Atom\DataBundle\Model\GeneratorType
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\GeneratorType $generator
     */
    public function setGenerator(GeneratorType $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\IconType
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\IconType $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\IdType
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\IdType $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\LogoType
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\LogoType $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\TextType
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\TextType $rights
     */
    public function setRights($rights)
    {
        $this->rights = $rights;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\TextType
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\TextType $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\TextType
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\TextType $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\DateTimeType
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\DateTimeType $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Add entry
     *
     * @param  EntryType $entry
     * @return EntryType
     */
    public function addEntry(EntryType $entry)
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Remove entry
     *
     * @param EntryType $entry
     */
    public function removeEntry(EntryType $entry)
    {
        $this->entries->removeElement($entry);
    }

    /**
     * Get entries
     *
     * @return Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Set entries
     *
     * @param  Collection $entries
     * @return EntryType
     */
    public function setEntries(Collection $entries)
    {
        $this->entries = $entries;

        return $this;
    }
}
