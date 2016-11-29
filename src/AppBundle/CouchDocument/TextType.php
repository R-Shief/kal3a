<?php

namespace AppBundle\CouchDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\Enum;
use Bangpound\Atom\Model\TextTypeInterface;
use Doctrine\ODM\CouchDB\Mapping\Annotations as ODM;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class TextType.
 */
class TextType extends CommonAttributes implements TextTypeInterface, DenormalizableInterface
{
    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string", nullable=true)
     */
    protected $type = Enum\TextConstructType::text;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $text;

    public function __construct($text = null)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text = null)
    {
        $this->text = $text;
    }

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

    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        if (is_string($data)) {
            $this->text = $data;

            return $this;
        } elseif (is_array($data) && !empty($data['text'])) {
            $this->text = $data['text'];
            if (isset($data['type'])) {
                $this->setType($data['type']);
            }
            if (isset($data['base'])) {
                $this->setBase($data['base']);
            }
            if (isset($data['lang'])) {
                $this->setLang($data['lang']);
            }

            return $this;
        }
    }
}
