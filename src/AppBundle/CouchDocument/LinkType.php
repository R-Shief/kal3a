<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\LinkTypeInterface;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use AppBundle\Annotations as App;

/**
 * Class LinkType.
 */
class LinkType extends CommonAttributes implements LinkTypeInterface
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $href;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $rel;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $type;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $hreflang;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $title;

    /**
     * @var int
     * @ODM\Field(type="integer")
     * @App\PropertyInfoType("int", nullable=true)
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
    public function setHref($href = null)
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
    public function setRel($rel = null)
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
    public function setType($type = null)
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
    public function setHreflang($hreflang = null)
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
    public function setTitle($title = null)
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
    public function setLength($length = null)
    {
        $this->length = $length;
    }
}
