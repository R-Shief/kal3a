<?php

namespace AppBundle\ESDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\CategoryTypeInterface;
use Bangpound\Atom\Model\CommonTypesInterface;
use Bangpound\Atom\Model\LinkTypeInterface;
use Bangpound\Atom\Model\PersonTypeInterface;
use ONGR\ElasticsearchBundle\Annotation as ES;

class CommonTypes extends CommonAttributes implements CommonTypesInterface
{
    /**
     * @var PersonType[]
     *
     * @ES\Embedded(class="AppBundle\ESDocument\PersonType", multiple=true)
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\ESDocument\PersonType"))
     */
    protected $authors;

    /**
     * @var CategoryType[]
     *
     * @ES\Embedded(class="AppBundle\ESDocument\CategoryType", multiple=true)
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\ESDocument\CategoryType"))
     */
    protected $categories;

    /**
     * @var PersonType[]
     *
     * @ES\Embedded(class="AppBundle\ESDocument\PersonType", multiple=true)
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\ESDocument\PersonType"))
     */
    protected $contributors;

    /**
     * @var LinkType[]
     *
     * @ES\Embedded(class="AppBundle\ESDocument\LinkType", multiple=true)
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\ESDocument\LinkType"))
     */
    protected $links;

    /**
     * Add author.
     *
     * @param PersonTypeInterface $author
     */
    public function addAuthor(PersonTypeInterface $author)
    {
        $this->authors[] = $author;
    }

    /**
     * Remove author.
     *
     * @param PersonTypeInterface $author
     */
    public function removeAuthor(PersonTypeInterface $author)
    {
        $this->authors = array_diff($this->authors, [$author]);
    }

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
     * Add category.
     *
     * @param CategoryTypeInterface $category
     */
    public function addCategory(CategoryTypeInterface $category)
    {
        $this->categories[] = $category;
    }

    /**
     * Remove category.
     *
     * @param CategoryTypeInterface $category
     */
    public function removeCategory(CategoryTypeInterface $category)
    {
        $this->categories = array_diff($this->categories, [$category]);
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
     * Add contributor.
     *
     * @param PersonTypeInterface $contributor
     */
    public function addContributor(PersonTypeInterface $contributor)
    {
        $this->contributors[] = $contributor;
    }

    /**
     * Remove contributor.
     *
     * @param PersonTypeInterface $contributor
     */
    public function removeContributor(PersonTypeInterface $contributor)
    {
        $this->contributors = array_diff($this->contributors, [$contributor]);
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
     * Add link.
     *
     * @param LinkTypeInterface $link
     */
    public function addLink(LinkTypeInterface $link)
    {
        $this->links[] = $link;
    }

    /**
     * Remove link.
     *
     * @param LinkTypeInterface $link
     */
    public function removeLink(LinkTypeInterface $link)
    {
        $this->links = array_diff($this->links, [$link]);
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