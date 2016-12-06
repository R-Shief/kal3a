<?php

namespace AppBundle\Document;

use Bangpound\Atom\Model\GeneratorTypeInterface;
use Bangpound\Atom\Model\SourceTypeInterface;
use Bangpound\Atom\Model\TextTypeInterface;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;
use AppBundle\Annotations as App;

/**
 * Class SourceType.
 *
 * @ES\Object
 */
class SourceType extends CommonTypes implements SourceTypeInterface
{
    public function __construct()
    {
        $this->authors = new Collection();
        $this->categories = new Collection();
        $this->contributors = new Collection();
        $this->links = new Collection();
    }

    /**
     * @var GeneratorType
     *
     * @ES\Embedded(class="AppBundle\Document\GeneratorType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\GeneratorType", nullable=true)
     */
    protected $generator;

    /**
     * @var string
     *
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $icon;

    /**
     * @var string
     *
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $id;

    /**
     * @var string
     *
     * @internal element (http://www.w3.org/2001/XMLSchema)
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $logo;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="AppBundle\Document\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\TextType", nullable=true)
     */
    protected $rights;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="AppBundle\Document\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\TextType", nullable=true)
     */
    protected $subtitle;

    /**
     * @var TextType
     *
     * @ES\Embedded(class="AppBundle\Document\TextType")
     * @App\PropertyInfoType("object", class="AppBundle\Document\TextType", nullable=true)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ES\Property(type="date", options={"format"="strict_date_optional_time||epoch_millis","ignore_malformed"=true})
     * @App\PropertyInfoType("object", class="\DateTime", nullable=true)
     */
    protected $updated;

    /**
     * @return \DateTimeInterface
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTimeInterface $updated
     */
    public function setUpdated(\DateTimeInterface $updated = null)
    {
        $this->updated = $updated;
    }

    /**
     * @return TextTypeInterface
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param TextTypeInterface $title
     */
    public function setTitle(TextTypeInterface $title = null)
    {
        $this->title = $title;
    }

    /**
     * @return TextTypeInterface
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param TextTypeInterface $subtitle
     */
    public function setSubtitle(TextTypeInterface $subtitle = null)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return TextTypeInterface
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param TextTypeInterface $rights
     */
    public function setRights(TextTypeInterface $rights = null)
    {
        $this->rights = $rights;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo = null)
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id = null)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon = null)
    {
        $this->icon = $icon;
    }

    /**
     * @return GeneratorTypeInterface
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @param GeneratorTypeInterface $generator
     */
    public function setGenerator(GeneratorTypeInterface $generator = null)
    {
        $this->generator = $generator;
    }
}
