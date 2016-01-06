<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TwitterProducerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('old_sound_rabbit_mq.twitter_producer')) {
            return;
        }

        $definition = $container->getDefinition('old_sound_rabbit_mq.twitter_producer');
        $definition->addMethodCall('setContentType', array('application/json'));
    }
}
