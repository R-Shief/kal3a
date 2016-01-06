<?php

namespace Bangpound\PhirehoseBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;

class BangpoundPhirehoseBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $pass = new RegisterListenersPass('event_dispatcher', 'bangpound_phirehose.event_listener', 'bangpound_phirehose.event_subscriber');
        $container->addCompilerPass($pass, PassConfig::TYPE_AFTER_REMOVING);
    }
}
