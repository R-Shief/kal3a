<?php

namespace Bangpound\Bundle\CastleBundle;

use Bangpound\Bundle\CastleBundle\DependencyInjection\Compiler\AddCouchDBTypesCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class BangpoundCastleBundle
 * @package Bangpound\Bundle\CastleBundle
 */
class BangpoundCastleBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
//        $container->addCompilerPass(new AddCouchDBTypesCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
    }
}
