<?php

namespace Bangpound\Bundle\CastleSearchBundle\Block;
use Doctrine\CouchDB\View\Query;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DateViewBlockService
 * @package Bangpound\Bundle\CastleSearchBundle\Block
 */
class DateViewBlockService extends ViewBlockService {

    /**
     * @param Query $query
     * @param BlockContextInterface $blockContext
     * @return array
     */
    public function results(Query $query, BlockContextInterface $blockContext) {
        $results = array();
        $settings = $blockContext->getSettings();

        $date_key = $settings['date_key'];
        $format = $settings['date_format'];
        foreach ($query->execute() as $result) {
            $date = date($format, mktime(
                isset($result['key'][$date_key + 3]) ? $result['key'][$date_key + 3] : 0,
                isset($result['key'][$date_key + 4]) ? $result['key'][$date_key + 4] : 0,
                isset($result['key'][$date_key + 5]) ? $result['key'][$date_key + 5] : 0,
                isset($result['key'][$date_key + 1]) ? $result['key'][$date_key + 1] : 0,
                isset($result['key'][$date_key + 2]) ? $result['key'][$date_key + 2] : 0,
                isset($result['key'][$date_key]) ? $result['key'][$date_key] : 0
            ));
            if ($date_key > 0) {
                $results[$result['key'][0]][$date] = $result['value'];
            }
            else {
                $results[$date] = $result['value'];
            }
        }
        return $results;
    }
}