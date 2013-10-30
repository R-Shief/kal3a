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
use Bangpound\Atom\DataBundle\Model\Enum\TextConstructType;

/**
 * TextType
 *
 * The Atom text construct is defined in section 3.1 of the format spec.
 *
 * @category DTOs
 * @author   xsd-php
 * @link     https://github.com/dalanhurst/xsd-php
 * @internal targetNamespace = http://www.w3.org/2005/Atom
 * @internal file:/Users/bjd/workspace/rshief/migration/xsd-php/atom.xsd.xml
 */
abstract class TextType extends CommonAttributes implements \JsonSerializable
{

    /**
     * @var Enum\TextConstructType
     * @internal attribute (http://www.w3.org/2001/XMLSchema)
     */
    protected $type = TextConstructType::text;

    /**
     * @var string
     */
    protected $text;

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return \Bangpound\Atom\DataBundle\Model\Enum\TextConstructType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \Bangpound\Atom\DataBundle\Model\Enum\TextConstructType $type
     */
    public function setType(TextConstructType $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getText();
    }
}
