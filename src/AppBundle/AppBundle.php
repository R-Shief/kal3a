<?php

namespace AppBundle;

use AppBundle\DependencyInjection\AppExtension;
use AppBundle\Guzzle\StackMiddlewareCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new StackMiddlewareCompilerPass());
    }

    public function getContainerExtension()
    {
        return new AppExtension();
    }
}
