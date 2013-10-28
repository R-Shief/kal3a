<?php

namespace Bangpound\Atom\DataBundle\Model;

/**
 * Class CommonAttributes
 * @package Bangpound\Atom\DataBundle\Model
 */
abstract class CommonAttributes
{
    protected $lang;

    protected $base;

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param string $base
     */
    public function setBase($base)
    {
        $this->base = $base;
    }
}
