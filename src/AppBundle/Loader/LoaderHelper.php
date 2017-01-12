<?php

namespace AppBundle\Loader;

class LoaderHelper
{
    /**
     * @param $array
     * @return string
     */
    public static function makeQueryParam($array)
    {
        return implode(',', (array) $array);
    }

    /**
     * @param $track
     * @param $follow
     * @param $location
     * @return array
     */
    public static function makeQueryParams($track, $follow, $location)
    {
        $params = [];
        $params['track'] = self::makeQueryParam($track);
        $params['follow'] = self::makeQueryParam($follow);
        $params['location'] = self::makeQueryParam(array_map(['self', 'makeQueryParam'], (array) $location));

        return $params;
    }
}
