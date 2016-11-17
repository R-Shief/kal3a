<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\SourceType as BaseSourceType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use AppBundle\Annotations as App;

/**
 * Class SourceType.
 *
 * @ES\Object
 */
class SourceType extends BaseSourceType
{
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

    /**
     * @var GeneratorType
     *
     * @ES\Embedded(class="GeneratorType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\GeneratorType")
     */
    protected $generator;

    /**
     * @var string
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     * @ODM\Field(type="string")
     */
    protected $icon;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @ODM\Field(type="string")
     */
    protected $id;

    /**
     * @var string
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     * @ODM\Field(type="string")
     */
    protected $logo;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="TextType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $rights;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="TextType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $subtitle;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="TextType")
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType")
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     * @ODM\Field(type="datetime")
     */
    protected $updated;
}
