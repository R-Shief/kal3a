<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\CategoryTypeInterface;
use Bangpound\Atom\Model\CommonTypesInterface;
use Bangpound\Atom\Model\LinkTypeInterface;
use Bangpound\Atom\Model\PersonTypeInterface;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

class CommonTypes extends CommonAttributes implements CommonTypesInterface
{
    /**
     * @var PersonType[]
     *
     * @ODM\Field()
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\PersonType"))
     */
    protected $authors;

    /**
     * @var CategoryType[]
     *
     * @ODM\Field()
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\CategoryType"))
     */
    protected $categories;

    /**
     * @var PersonType[]
     *
     * @ODM\Field()
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\PersonType"))
     */
    protected $contributors;

    /**
     * @var LinkType[]
     *
     * @ODM\Field()
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\LinkType"))
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
        $this->authors = $authors;
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
    public function setCategories($categories = [])
    {
        $this->categories = $categories;
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
        $this->contributors = $contributors;
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
        $this->links = $links;
    }
}
