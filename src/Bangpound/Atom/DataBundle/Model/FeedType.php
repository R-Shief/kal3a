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
abstract class FeedType
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
    protected $entry;
}
