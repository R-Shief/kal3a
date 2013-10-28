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
     * @return Collection
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set authors
     *
     * @param  Collection $authors
     * @return EntryType
     */
    public function setAuthors(Collection $authors)
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
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set category
     *
     * @param  Collection $categories
     * @return EntryType
     */
    public function setCategories(Collection $categories)
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
     * @return Collection
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * Set contributors
     *
     * @param  Collection $contributors
     * @return EntryType
     */
    public function setContributors(Collection $contributors)
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
     * @return Collection
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set links
     *
     * @param  Collection $links
     * @return EntryType
     */
    public function setLinks(Collection $links)
    {
        $this->links = $links;

        return $this;
    }
}
