<?php

namespace Bangpound\Bundle\CastleSearchBundle\Block;

use Doctrine\CouchDB\View\Query;
use Sonata\BlockBundle\Block\BlockContextInterface;

/**
 * Interface ViewBlockServiceInterface
 * @package Bangpound\Bundle\CastleSearchBundle\Block
 */
interface ViewBlockServiceInterface {

    /**
     * @param Query $query
     * @param BlockContextInterface $blockContext
     * @return mixed
     */
    public function results(Query $query, BlockContextInterface $blockContext);
} 