<?php

namespace AppBundle\ESDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\EntryType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * Class AtomEntry.
 *
 * @ES\Document(type="atom")
 */
class AtomEntry extends EntryType
{
    public function __construct()
    {
        $this->authors = new Collection();
        $this->categories = new Collection();
        $this->contributors = new Collection();
        $this->links = new Collection();
    }

    /**
     * @var string
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $id;

    /**
     * @var ContentType
     * @ES\Embedded(class="AppBundle\ESDocument\ContentType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\ContentType", nullable=true)
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     * @App\PropertyInfoType("object", class="DateTime", nullable=true)
     */
    protected $published;

    /**
     * @var TextType
     * @ES\Embedded(class="AppBundle\ESDocument\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\TextType", nullable=true)
     */
    protected $rights;

    /**
     * @var SourceType
     *
     * @ES\Embedded(class="AppBundle\ESDocument\SourceType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\SourceType", nullable=true)
     */
    protected $source;

    /**
     * @var TextType
     * @ES\Embedded(class="AppBundle\ESDocument\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\TextType", nullable=true)
     */
    protected $summary;

    /**
     * @var TextType
     * @ES\Embedded(class="AppBundle\ESDocument\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\TextType", nullable=true)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     * @App\PropertyInfoType("object", class="DateTime", nullable=true)
     */
    protected $updated;

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
     * @App\PropertyInfoType("array", nullable=true, collection=true, nullable=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\ESDocument\LinkType"))
     */
    protected $links;
}
