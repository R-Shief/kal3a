<?php

namespace Bangpound\Atom\DataBundle\Model;

use Doctrine\Common\Collections\Collection;

trait CommonTypes
{
    /**
     * Add author
     *
     * @param  PersonType $author
     * @return EntryType
     */
    public function addAuthor(PersonType $author)
    {
        $this->authors[] = $author;

        return $this;
    }

    /**
     * Remove author
     *
     * @param PersonType $author
     */
    public function removeAuthor(PersonType $author)
    {
        $this->authors->removeElement($author);
    }

    /**
     * Get authors
     *
     * @return array
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set authors
     *
     * @param  array $authors
     * @return EntryType
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;

        return $this;
    }

    /**
     * Add category
     *
     * @param  CategoryType $category
     * @return EntryType
     */
    public function addCategory(CategoryType $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param CategoryType $category
     */
    public function removeCategory(CategoryType $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get category
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set category
     *
     * @param  array $categories
     * @return EntryType
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Add contributor
     *
     * @param  PersonType $contributor
     * @return EntryType
     */
    public function addContributor(PersonType $contributor)
    {
        $this->contributors[] = $contributor;

        return $this;
    }

    /**
     * Remove contributor
     *
     * @param PersonType $contributor
     */
    public function removeContributor(PersonType $contributor)
    {
        $this->contributors->removeElement($contributor);
    }

    /**
     * Get contributors
     *
     * @return array
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * Set contributors
     *
     * @param  array $contributors
     * @return EntryType
     */
    public function setContributors($contributors)
    {
        $this->contributors = $contributors;

        return $this;
    }

    /**
     * Add link
     *
     * @param  LinkType  $link
     * @return EntryType
     */
    public function addLink(LinkType $link)
    {
        $this->links[] = $link;

        return $this;
    }

    /**
     * Remove link
     *
     * @param LinkType $link
     */
    public function removeLink(LinkType $link)
    {
        $this->links->removeElement($link);
    }

    /**
     * Get links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set links
     *
     * @param  array $links
     * @return EntryType
     */
    public function setLinks($links)
    {
        $this->links = $links;

        return $this;
    }
}
