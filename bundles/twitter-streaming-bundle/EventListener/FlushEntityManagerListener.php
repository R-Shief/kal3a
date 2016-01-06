<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;

class FlushEntityManagerListener
{
    private $om;
    private $consumerName;

    public function __construct(ObjectManager $om, $consumerName)
    {
        $this->om = $om;
        $this->consumerName = $consumerName;
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event)
    {
        $command = $event->getCommand();
        $input= $event->getInput();

        if ('rabbitmq:consumer' === $command->getName() && ($this->consumerName === $input->getArgument('name'))) {
            $this->om->flush();
        }
    }
}
