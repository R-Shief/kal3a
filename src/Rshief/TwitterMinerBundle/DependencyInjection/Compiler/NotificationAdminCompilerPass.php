<?php

namespace Rshief\TwitterMinerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class NotificationAdminCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sonata.notification.admin.message')) {
            return;
        }

        $container->removeDefinition('sonata.notification.admin.message');
    }
}
