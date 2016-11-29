<?php

namespace AppBundle\CouchDocument;

use Bangpound\Atom\Model\SourceType as BaseSourceType;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use AppBundle\Annotations as App;

/**
 * Class SourceType.
 */
class SourceType extends BaseSourceType
{
    /**
     * @var PersonType[]
     *
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\PersonType"))
     */
    protected $authors;

    /**
     * @var CategoryType[]
     *
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\CategoryType"))
     */
    protected $categories;

    /**
     * @var PersonType[]
     *
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\PersonType"))
     */
    protected $contributors;

    /**
     * @var LinkType[]
     *
     * @App\PropertyInfoType("array", nullable=true, collection=true, collectionKeyType=@App\PropertyInfoType("int"), collectionValueType=@App\PropertyInfoType("object", nullable=false, class="AppBundle\CouchDocument\LinkType"))
     */
    protected $links;

    /**
     * @var GeneratorType
     *
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\GeneratorType", nullable=true)
     */
    protected $generator;

    /**
     * @var string
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $icon;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $id;

    /**
     * @var string
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $logo;

    /**
     * @var TextType
     *
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $rights;

    /**
     * @var TextType
     *
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $subtitle;

    /**
     * @var TextType
     *
     * @App\PropertyInfoType("object", class="AppBundle\CouchDocument\TextType", nullable=true)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="datetime")
     */
    protected $updated;
}
