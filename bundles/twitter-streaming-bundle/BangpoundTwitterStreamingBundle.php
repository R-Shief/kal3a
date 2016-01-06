<?php

namespace Bangpound\Bundle\TwitterStreamingBundle;

use Bangpound\Bundle\TwitterStreamingBundle\DependencyInjection\Compiler\TwitterProducerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BangpoundTwitterStreamingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TwitterProducerCompilerPass());
    }
}
