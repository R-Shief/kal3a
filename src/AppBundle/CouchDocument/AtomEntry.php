<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\EntryType;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;

/**
 * Class AtomEntry.
 *
 * @ODM\Document(type="atom")
 */
class AtomEntry extends EntryType
{
    /**
     * @var string
     * @ODM\Id()
     * @App\PropertyInfoType("string", nullable=false)
     */
    protected $_id;

    /**
     * @var string
     * @ODM\Version()
     * @App\PropertyInfoType("string", nullable=false)
     */
    protected $_rev;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=false)
     */
    protected $id;

    /**
     * @var ContentType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\ContentType")
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="datetime")
     * @App\PropertyInfoType("object", class="DateTime")
     */
    protected $published;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $rights;

    /**
     * @var SourceType
     *
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\SourceType")
     */
    protected $source;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $summary;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="datetime")
     * @App\PropertyInfoType("object", class="DateTime")
     */
    protected $updated;

    /**
     * @var PersonType[]
     *
     * @ODM\Field()
     * @App\PropertyInfoType("array", collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\PersonType"))
     */
    protected $authors;

    /**
     * @var CategoryType[]
     *
     * @ODM\Field()
     * @App\PropertyInfoType("array", collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\CategoryType"))
     */
    protected $categories;

    /**
     * @var PersonType[]
     *
     * @ODM\Field()
     * @App\PropertyInfoType("array", collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\PersonType"))
     */
    protected $contributors;

    /**
     * @var LinkType[]
     *
     * @ODM\Field()
     * @App\PropertyInfoType("array", collection=true, nullable=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\LinkType"))
     */
    protected $links;
}
