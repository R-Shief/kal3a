<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use ONGR\ElasticsearchBundle\Collection\Collection;
use ONGR\ElasticsearchBundle\Annotation as ES;

trait CommonTypes
{
    /**
     * @var Collection (atom:personType)
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\PersonType", multiple=true)
     */
    protected $authors = [];

    /**
     * @var Collection (atom:categoryType)
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\CategoryType", multiple=true)
     */
    protected $categories = [];

    /**
     * @var Collection (atom:personType)
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\PersonType", multiple=true)
     */
    protected $contributors = [];

    /**
     * @var Collection (atom:linksType)
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\LinkType", multiple=true)
     */
    protected $links = [];

    /**
     * @param PersonType $author
     *
     * @return $this
     */
    public function addAuthor(PersonType $author)
    {
        $this->authors[] = $author;
    }

    /**
     * Get authors.
     *
     * @return Collection
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set authors.
     *
     * @param array $authors
     *
     * @return static
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }

    /**
     * Add category.
     *
     * @param CategoryType $category
     *
     * @return static
     */
    public function addCategory(CategoryType $category)
    {
        $this->categories[] = $category;
    }

    /**
     * Get category.
     *
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set category.
     *
     * @param array $categories
     *
     * @return static
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Add contributor.
     *
     * @param PersonType $contributor
     *
     * @return static
     */
    public function addContributor(PersonType $contributor)
    {
        $this->contributors[] = $contributor;
    }

    /**
     * Get contributors.
     *
     * @return Collection
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * Set contributors.
     *
     * @param array $contributors
     *
     * @return static
     */
    public function setContributors($contributors)
    {
        $this->contributors = $contributors;
    }

    /**
     * Add link.
     *
     * @param LinkType $link
     */
    public function addLink(LinkType $link)
    {
        $this->links[] = $link;
    }

    /**
     * Get links.
     *
     * @return Collection
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set links.
     *
     * @param array $links
     *
     * @return static
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }
}
