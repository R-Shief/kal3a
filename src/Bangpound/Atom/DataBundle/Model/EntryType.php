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

namespace Bangpound\Atom\Model;

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
class EntryType
{

    /**
     * @var PersonType (atom:personType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $dauthor;

    /**
     * @var CategoryType (atom:categoryType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $dcategory;

    /**
     * @var ContentType (atom:contentType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $content;

    /**
     * @var PersonType (atom:personType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $dcontributor;

    /**
     * @var IdType (atom:idType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $id;

    /**
     * @var LinkType (atom:linkType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $link;

    /**
     * @var DateTimeType (atom:dateTimeType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $published;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $rights;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $source;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $summary;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $title;

    /**
     * @var DateTimeType (atom:dateTimeType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    private $updated;

    /**
     * @return \Bangpound\Atom\Model\PersonType
     */
    public function getDauthor()
    {
        return $this->dauthor;
    }

    /**
     * @param \Bangpound\Atom\Model\PersonType $dauthor
     */
    public function setDauthor($dauthor)
    {
        $this->dauthor = $dauthor;
    }

    /**
     * @return \Bangpound\Atom\Model\CategoryType
     */
    public function getDcategory()
    {
        return $this->dcategory;
    }

    /**
     * @param \Bangpound\Atom\Model\CategoryType $dcategory
     */
    public function setDcategory($dcategory)
    {
        $this->dcategory = $dcategory;
    }

    /**
     * @return \Bangpound\Atom\Model\ContentType
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \Bangpound\Atom\Model\ContentType $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
