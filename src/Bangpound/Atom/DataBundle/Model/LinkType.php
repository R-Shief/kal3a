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
 * LinkType
 *
 * The Atom link construct is defined in section 3.4 of the format spec.
 *
 * @category DTOs
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */
abstract class LinkType extends CommonAttributes
{

    /**
     * @var string (xs:anyURI)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    protected $href;

    /**
     * @var string (xs:string)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    protected $rel;

    /**
     * @var string (xs:string)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    protected $type;

    /**
     * @var string (xs:NMTOKEN)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    protected $hreflang;

    /**
     * @var string (xs:string)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    protected $title;

    /**
     * @var int (xs:positiveInteger)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    protected $length;

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @param string $rel
     */
    public function setRel($rel)
    {
        $this->rel = $rel;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getHreflang()
    {
        return $this->hreflang;
    }

    /**
     * @param string $hreflang
     */
    public function setHreflang($hreflang)
    {
        $this->hreflang = $hreflang;
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
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }
}
