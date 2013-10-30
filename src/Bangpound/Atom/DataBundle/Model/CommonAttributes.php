<?php

namespace Bangpound\Atom\DataBundle\Model;
use Doctrine\ODM\CouchDB\Types\DateTimeType;
use Doctrine\ODM\CouchDB\Types\Type;

/**
 * Class CommonAttributes
 *
 * Every Atom class inherits from this,
 *
 * @package Bangpound\Atom\DataBundle\Model
 */
abstract class CommonAttributes implements \JsonSerializable
{
    protected $lang;

    protected $base;

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param string $base
     */
    public function setBase($base)
    {
        $this->base = $base;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $output = array();
        foreach (get_object_vars($this) as $key => $value) {
            if ($value instanceof \DateTime) {
                // Clumsy way to avoid writing mappings for sub-documents and all that.
                $output[$key] = Type::getType('datetime')->convertToCouchDBValue($value);
            }
            else {
                $output[$key] = $value;
            }
        }
        return array_filter($output);
    }
}
