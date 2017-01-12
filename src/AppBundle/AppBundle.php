<?php

namespace AppBundle;

use AppBundle\Console\AddConsoleCommandPass;
use AppBundle\DependencyInjection\AppExtension;
use AppBundle\DependencyInjection\Compiler\AttachPluginsCompilerPass;
use AppBundle\Guzzle\StackMiddlewareCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new StackMiddlewareCompilerPass());
        $container->addCompilerPass(new AddConsoleCommandPass());
        $container->addCompilerPass(new AttachPluginsCompilerPass(EventLoop\Configurator::class, 'event_loop.plugin', 'nab3a.event_loop'), PassConfig::TYPE_BEFORE_REMOVING);
        $container->addCompilerPass(new AttachPluginsCompilerPass(Evenement\Configurator::class, 'evenement.plugin'), PassConfig::TYPE_BEFORE_REMOVING);
    }

    public function getContainerExtension()
    {
        return new AppExtension();
    }
}
