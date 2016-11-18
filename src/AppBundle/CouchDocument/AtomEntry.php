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
     * @App\PropertyInfoType("string")
     */
    protected $_id;

    /**
     * @var string
     * @ODM\Version()
     * @App\PropertyInfoType("string")
     */
    protected $_rev;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $id;

    /**
     * @var ContentType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\ContentType", nullable=true)
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="datetime")
     * @App\PropertyInfoType("object", class="DateTime", nullable=true)
     */
    protected $published;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $rights;

    /**
     * @var SourceType
     *
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\SourceType", nullable=true)
     */
    protected $source;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $summary;

    /**
     * @var TextType
     * @ODM\Field()
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="datetime")
     * @App\PropertyInfoType("object", class="DateTime", nullable=true)
     */
    protected $updated;

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
     * @App\PropertyInfoType("array", nullable=true, collection=true, nullable=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\LinkType"))
     */
    protected $links;
}
