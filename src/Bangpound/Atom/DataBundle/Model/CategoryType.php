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
 * CategoryType
 *
 * The Atom cagegory construct is defined in section 4.2.2 of the format spec.
 *
 * @category DTOs
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */
class CategoryType
{

    /**
     * @var string (xs:string)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    public $term;

    /**
     * @var string (xs:anyURI)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    public $scheme;

    /**
     * @var string (xs:string)
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    public $label;
}
