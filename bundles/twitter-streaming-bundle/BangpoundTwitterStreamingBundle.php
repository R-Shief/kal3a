<?php

namespace Bangpound\Bundle\TwitterStreamingBundle;

use Bangpound\Bundle\TwitterStreamingBundle\DependencyInjection\Compiler\TwitterProducerCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BangpoundTwitterStreamingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $pass = new RegisterListenersPass('event_dispatcher', 'bangpound_phirehose.event_listener', 'bangpound_phirehose.event_subscriber');
        $container->addCompilerPass($pass, PassConfig::TYPE_AFTER_REMOVING);

        $container->addCompilerPass(new TwitterProducerCompilerPass());
    }
}
