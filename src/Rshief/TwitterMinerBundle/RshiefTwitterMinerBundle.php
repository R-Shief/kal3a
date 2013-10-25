<?php

namespace Rshief\TwitterMinerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Rshief\TwitterMinerBundle\DependencyInjection\Compiler\NotificationAdminCompilerPass;

class RshiefTwitterMinerBundle extends Bundle
{
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new NotificationAdminCompilerPass());
    }
}
