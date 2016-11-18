<?php

namespace AppBundle\ESDocument;

use AppBundle\Annotations as App;
use Bangpound\Atom\Model\TextType as BaseTextType;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Bangpound\Atom\Model\Enum;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class TextType.
 *
 * @ES\Object
 */
class TextType extends BaseTextType implements DenormalizableInterface
{
    /**
     * @var string
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $type = Enum\TextConstructType::text;

    /**
     * @var string
     * @ES\Property(type="string")
     * @App\PropertyInfoType("string")
     */
    protected $text;

    public function __construct($text = null)
    {
        $this->text = $text;
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