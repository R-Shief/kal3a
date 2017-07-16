<?php

namespace AppBundle\Document;

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
     * @ES\Property(
     *   type="text",
     *   options={
     *     "fields"={
     *       "keyword"={
     *         "type"="keyword"
     *       }
     *     }
     *   }
     * )
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $type = 'text';

    /**
     * @var string
     * @ES\Property(type="text")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $src;

    /**
     * @var string
     * @ES\Property(type="text")
     * @App\PropertyInfoType("string", nullable=true)
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
    public function setType($type = null)
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
    public function setSrc($src = null)
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
    public function setContent($content = null)
    {
        $this->content = $content;
    }
}
