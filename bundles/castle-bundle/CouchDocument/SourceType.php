<?php

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Bangpound\Atom\DataBundle\CouchDocument\SourceType as BaseSourceType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * Class SourceType.
 *
 * @ES\Object
 */
class SourceType extends BaseSourceType
{
    use CommonTypes;

    public function __construct()
    {
        $this->authors = new Collection();
        $this->categories = new Collection();
        $this->contributors = new Collection();
        $this->links = new Collection();
    }

    /**
     * @var GeneratorType (atom:generatorType)
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\GeneratorType")
     */
    protected $generator;

    /**
     * @var string (atom:iconType)
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $icon;

    /**
     * @var string (atom:idType)
     *
     * @ES\Property(type="string")
     */
    protected $id;

    /**
     * @var string (atom:logoType)
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     */
    protected $logo;

    /**
     * @var TextType (atom:textType)
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\TextType")
     */
    protected $rights;

    /**
     * @var TextType (atom:textType)
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\TextType")
     */
    protected $subtitle;

    /**
     * @var TextType (atom:textType)
     *
     * @ES\Embedded(class="Bangpound\Bundle\CastleBundle\CouchDocument\TextType")
     */
    protected $title;

    /**
     * @var \DateTime (atom:dateTimeType)
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     */
    protected $updated;
}
