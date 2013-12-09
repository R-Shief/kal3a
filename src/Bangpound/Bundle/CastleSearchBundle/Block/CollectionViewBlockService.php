<?php
/**
 * Created by PhpStorm.
 * User: bjd
 * Date: 12/9/13
 * Time: 1:45 AM
 */

namespace Bangpound\Bundle\CastleSearchBundle\Block;


use Doctrine\CouchDB\View\Query;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollectionViewBlockService extends ViewBlockService {

    private $map;

    public function setMap($map) {
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


    public function results(Query $query, BlockContextInterface $blockContext)
    {
        $results = array();
        foreach ($query->execute() as $result) {
            $name = $this->map[$result['key'][0]];
            $results[] = [
                'key' => $result['key'][0],
                'label' => isset($this->map[$result['key'][0]]) ? $this->map[$result['key'][0]] : $result['key'][0],
                'value' => $result['value'],
            ];
        }

        return $results;

    }
}