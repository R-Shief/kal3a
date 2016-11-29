<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\CommonAttributesInterface;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class CommonAttributes.
 */
class CommonAttributes implements CommonAttributesInterface
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $base;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $lang;

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
    public function setLang($lang = null)
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
    public function setBase($base = null)
    {
        $this->base = $base;
    }
}
