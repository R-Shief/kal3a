<?php

namespace AppBundle\ESDocument;

use Bangpound\Atom\Model\SourceType as BaseSourceType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;
use AppBundle\Annotations as App;

/**
 * Class SourceType.
 *
 * @ES\Object
 */
class SourceType extends BaseSourceType
{
    public function __construct()
    {
        $this->authors = new Collection();
        $this->categories = new Collection();
        $this->contributors = new Collection();
        $this->links = new Collection();
    }

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
     * @var GeneratorType
     *
     * @ES\Embedded(class="AppBundle\ESDocument\GeneratorType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\GeneratorType", nullable=true)
     */
    protected $generator;

    /**
     * @var string
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $icon;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     */
    protected $id;

    /**
     * @var string
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $logo;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="AppBundle\ESDocument\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\TextType", nullable=true)
     */
    protected $rights;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="AppBundle\ESDocument\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\TextType", nullable=true)
     */
    protected $subtitle;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="AppBundle\ESDocument\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\ESDocument\TextType", nullable=true)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     */
    protected $updated;
}
