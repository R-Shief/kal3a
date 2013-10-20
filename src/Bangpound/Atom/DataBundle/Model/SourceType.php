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
 * SourceType
 *
 * The Atom source construct is defined in section 4.2.11 of the format spec.
 *
 * @category DTOs
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */
class SourceType
{

    /**
     * @var PersonType (atom:personType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $dauthor;

    /**
     * @var CategoryType (atom:categoryType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $dcategory;

    /**
     * @var PersonType (atom:personType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $dcontributor;

    /**
     * @var GeneratorType (atom:generatorType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $dgenerator;

    /**
     * @var IconType (atom:iconType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $icon;

    /**
     * @var IdType (atom:idType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $id;

    /**
     * @var LinkType (atom:linkType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $link;

    /**
     * @var LogoType (atom:logoType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $logo;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $rights;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $subtitle;

    /**
     * @var TextType (atom:textType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $title;

    /**
     * @var DateTimeType (atom:dateTimeType)
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    public $updated;
}
