<?php

namespace Rshief\PubsubBundle;

use Rshief\PubsubBundle\DependencyInjection\Compiler\ReplaceHttpClientCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RshiefPubsubBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ReplaceHttpClientCompilerPass());
    }
}
