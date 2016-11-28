<?php

namespace AppBundle\ESDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\ContentTypeInterface;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class ContentType.
 *
 * @ES\Object
 */
class ContentType extends CommonAttributes implements ContentTypeInterface
{
    /**
     * @var string
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $type = 'text';

    /**
     * @var string
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $src;

    /**
     * @var string
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $content;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param string $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
