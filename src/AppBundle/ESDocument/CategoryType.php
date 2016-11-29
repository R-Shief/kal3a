<?php

namespace AppBundle\ESDocument;

use Bangpound\Atom\Model\CategoryTypeInterface;
use ONGR\ElasticsearchBundle\Annotation as ES;
use AppBundle\Annotations as App;

/**
 * Class CategoryType.
 *
 * @ES\Object
 */
class CategoryType extends CommonAttributes implements CategoryTypeInterface
{
    /**
     * @var string
     *
     * @ES\Property(type="string", options={"analyzer"="tag_analyzer"})
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $term;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $scheme;

    /**
     * @var string
     *
     * @ES\Property(type="string")
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
