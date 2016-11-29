<?php

namespace AppBundle\ESDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\CommonAttributesInterface;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class CommonAttributes.
 */
class CommonAttributes implements CommonAttributesInterface
{
    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $base;

    /**
     * @var string
     *
     * @ES\Property(type="string")
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
