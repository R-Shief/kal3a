<?php

namespace Rshief\PubsubBundle;

/**
 * Class JsonXMLElement
 * @package Rshief\PubsubBundle
 */
class JsonXMLElement extends \SimpleXMLElement implements \JsonSerializable {

    /**
      * To check the allowed nesting depth of the XML tree during xml2json conversion.
      *
      * @var int
      */
    public static $maxRecursionDepthAllowed = 25;

    /**
     * @return array
     */
    public function jsonSerialize() {
        $resultArray = static::_processXml($this, $ignoreXmlAttributes = false);
        return $resultArray;
    }
    
    /**
     * Return the value of an XML attribute text or the text between
     * the XML tags
     *
     * In order to allow Zend\Json\Expr from xml, we check if the node
     * matches the pattern that try to detect if it is a new Zend\Json\Expr
     * if it matches, we return a new Zend\Json\Expr instead of a text node
     *
     * @param SimpleXMLElement $simpleXmlElementObject
     * @return Expr|string
     */
    protected static function _getXmlValue($simpleXmlElementObject)
    {
        return (trim(strval($simpleXmlElementObject)));
    }

    /**
     * @param $simpleXmlElementObject
     * @param $ignoreXmlAttributes
     * @param int $recursionDepth
     * @return array
     * @throws Exception
     */
    protected static function _processXml($simpleXmlElementObject, $ignoreXmlAttributes, $recursionDepth = 0) {
        // Keep an eye on how deeply we are involved in recursion.
        if ($recursionDepth > static::$maxRecursionDepthAllowed) {
            // XML tree is too deep. Exit now by throwing an exception.
            throw new Exception(
                "Function _processXml exceeded the allowed recursion depth of "
                .  static::$maxRecursionDepthAllowed
            );
        }

        $children   = $simpleXmlElementObject->children();
        $name       = $simpleXmlElementObject->getName();
        $value      = static::_getXmlValue($simpleXmlElementObject);
        $attributes = (array) $simpleXmlElementObject->attributes();

        if (in_array($name, array('content', 'summary', 'rights', 'title', 'subtitle'))) {
            if (!empty($attributes) && !$ignoreXmlAttributes) {
                foreach ($attributes['@attributes'] as $k => $v) {
                    $attributes['@attributes'][$k] = static::_getXmlValue($v);
                }
                $attributes['@text'] = $simpleXmlElementObject->children()->asXml();
                return array($name => $attributes);
            }

            return array($name => $value);
        }

        if (!count($children)) {
            if (!empty($attributes) && !$ignoreXmlAttributes) {
                foreach ($attributes['@attributes'] as $k => $v) {
                    $attributes['@attributes'][$k] = static::_getXmlValue($v);
                }
                if (!empty($value)) {
                    $attributes['@text'] = $value;
                }
                return array($name => $attributes);
            }

            return array($name => $value);
        }

        $childArray = array();
        foreach ($children as $child) {
            $childname = $child->getName();
            $element   = static::_processXml($child, $ignoreXmlAttributes, $recursionDepth + 1);
            if (array_key_exists($childname, $childArray)) {
                if (empty($subChild[$childname])) {
                    $childArray[$childname] = array($childArray[$childname]);
                    $subChild[$childname]   = true;
                }
                $childArray[$childname][] = $element[$childname];
            } else {
                $childArray[$childname] = $element[$childname];
            }
        }

        if (!empty($attributes) && !$ignoreXmlAttributes) {
            foreach ($attributes['@attributes'] as $k => $v) {
                $attributes['@attributes'][$k] = static::_getXmlValue($v);
            }
            $childArray['@attributes'] = $attributes['@attributes'];
        }

        if (!empty($value)) {
            $childArray['@text'] = $value;
        }

        return array($name => $childArray);
    }
}
