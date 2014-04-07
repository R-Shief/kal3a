<?php

namespace Bangpound\Bundle\CastleSearchBundle\Block;

use Doctrine\CouchDB\View\Query;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CollectionViewBlockService
 * @package Bangpound\Bundle\CastleSearchBundle\Block
 */
class CollectionViewBlockService extends ViewBlockService
{
    private $map;

    /**
     * @param $map
     */
    public function setMap($map)
    {
        $this->map = $map;
    }

    /**
     * Define the default options for the block
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        parent::setDefaultSettings($resolver);
        $resolver->replaceDefaults(array(
            'template' => 'BangpoundCastleSearchBundle:Block:block_view_collection.html.twig',
        ));
    }

    /**
     * @param  Query                 $query
     * @param  BlockContextInterface $blockContext
     * @return mixed
     */
    public function results(Query $query, BlockContextInterface $blockContext)
    {
        $results = array();
        foreach ($query->execute() as $result) {
            $results[] = [
                'key' => $result['key'][0],
                'label' => isset($this->map[$result['key'][0]]) ? $this->map[$result['key'][0]] : $result['key'][0],
                'value' => $result['value'],
            ];
        }

        return $results;

    }
}
