<?php
/**
 * PHP classes for atom.xsd.xml
 *
 * This version of the Atom schema is based on version 1.0 of the format specifications,
 * found here http://www.atomenabled.org/developers/syndication/atom-format-spec.php.
 * An Atom document may have two root elements, feed and entry, as defined in section 2.
 *
 * PHP Version 5.3
 *
 * @category Enums
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */

namespace Bangpound\Atom\DataBundle\Model\Enum;

/**
 * TextConstructType
 *
 * @category Enums
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */
final class TextConstructType extends \RobotSnowfall\Enum
{

    /**
     * @staticvar string (xs:token)
     * @internal enumeration (http://www.w3.org/2001/XMLSchema)
     */
    const text = "text";

    /**
     * @staticvar string (xs:token)
     * @internal enumeration (http://www.w3.org/2001/XMLSchema)
     */
    const html = "html";

    /**
     * @staticvar string (xs:token)
     * @internal enumeration (http://www.w3.org/2001/XMLSchema)
     */
    const xhtml = "xhtml";
}
