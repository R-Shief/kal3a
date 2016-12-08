<?php

namespace AppBundle\Document;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\CategoryTypeInterface;
use Bangpound\Atom\Model\CommonTypesInterface;
use Bangpound\Atom\Model\LinkTypeInterface;
use Bangpound\Atom\Model\PersonTypeInterface;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;

class CommonTypes extends CommonAttributes implements CommonTypesInterface
{
    /**
     * @var PersonType[]
     *
     * @ES\Embedded(class="AppBundle\Document\PersonType", multiple=true)
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\Document\PersonType"))
     */
    protected $authors;

    /**
     * @var CategoryType[]
     *
     * @ES\Embedded(class="AppBundle\Document\CategoryType", multiple=true)
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\Document\CategoryType"))
     */
    protected $categories;

    /**
     * @var PersonType[]
     *
     * @ES\Embedded(class="AppBundle\Document\PersonType", multiple=true)
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\Document\PersonType"))
     */
    protected $contributors;

    /**
     * @var LinkType[]
     *
     * @ES\Embedded(class="AppBundle\Document\LinkType", multiple=true)
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\Document\LinkType"))
     */
    protected $links;

    /**
     * Get authors.
     *
     * @return PersonTypeInterface[]
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set authors.
     *
     * @param PersonTypeInterface[] $authors
     */
    public function setAuthors($authors = [])
    {
        $this->authors = new Collection($authors);
    }

    /**
     * Get category.
     *
     * @return CategoryTypeInterface[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set category.
     *
     * @param CategoryTypeInterface[] $categories
     */
    public function setCategories(array $categories = null)
    {
        $this->categories = new Collection($categories);
    }

    /**
     * Get contributors.
     *
     * @return PersonTypeInterface[]
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * Set contributors.
     *
     * @param PersonTypeInterface[] $contributors
     */
    public function setContributors($contributors = [])
    {
        $this->contributors = new Collection($contributors);
    }

    /**
     * Get links.
     *
     * @return LinkTypeInterface[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set links.
     *
     * @param LinkTypeInterface[] $links
     */
    public function setLinks($links = [])
    {
        $this->links = new Collection($links);
    }
}
