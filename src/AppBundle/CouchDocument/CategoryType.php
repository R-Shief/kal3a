<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\CategoryTypeInterface;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use AppBundle\Annotations as App;

/**
 * Class CategoryType.
 */
class CategoryType extends CommonAttributes implements CategoryTypeInterface
{
    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $term;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $scheme;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $label;

    /**
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param string $term
     */
    public function setTerm($term = null)
    {
        $this->term = $term;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     */
    public function setScheme($scheme = null)
    {
        $this->scheme = $scheme;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label = null)
    {
        $this->label = $label;
    }
}
