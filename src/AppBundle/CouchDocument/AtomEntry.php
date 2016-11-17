<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\EntryType;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * Class AtomEntry.
 *
 * @ODM\Document(type="atom")
 * @ES\Document(type="atom")
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
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=false)
     */
    protected $id;

    /**
     * @var ContentType
     * @ES\Embedded(class="ContentType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\ContentType")
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     * @ODM\Field(type="datetime")
     * @App\PropertyInfoType("object", class="DateTime")
     */
    protected $published;

    /**
     * @var TextType
     * @ES\Embedded(class="TextType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $rights;

    /**
     * @var SourceType
     *
     * @ES\Embedded(class="SourceType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\SourceType")
     */
    protected $source;

    /**
     * @var TextType
     * @ES\Embedded(class="TextType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $summary;

    /**
     * @var TextType
     * @ES\Embedded(class="TextType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     * @App\PropertyInfoType("object", class="DateTime")
     */
    protected $updated;

    /**
     * @var PersonType[]
     *
     * @ES\Embedded(class="PersonType", multiple=true)
     * @App\PropertyInfoType("array", collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\PersonType"))
     */
    protected $authors;

    /**
     * @var CategoryType[]
     *
     * @ES\Embedded(class="CategoryType", multiple=true)
     * @App\PropertyInfoType("array", collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\CategoryType"))
     */
    protected $categories;

    /**
     * @var PersonType[]
     *
     * @ES\Embedded(class="PersonType", multiple=true)
     * @App\PropertyInfoType("array", collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\PersonType"))
     */
    protected $contributors;

    /**
     * @var LinkType[]
     *
     * @ES\Embedded(class="LinkType", multiple=true)
     * @App\PropertyInfoType("array", collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\LinkType"))
     */
    protected $links;

    public function __construct()
    {
        $this->authors = new Collection();
        $this->categories = new Collection();
        $this->contributors = new Collection();
        $this->links = new Collection();
    }
}
