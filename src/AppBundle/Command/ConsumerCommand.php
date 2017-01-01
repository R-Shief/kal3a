<?php

namespace AppBundle\Command;

use OldSound\RabbitMqBundle\RabbitMq\Consumer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends \OldSound\RabbitMqBundle\Command\ConsumerCommand
{
    /** @var  \OldSound\RabbitMqBundle\RabbitMq\Consumer */
    protected $consumer;

    protected function configure()
    {
        parent::configure();
        $this->setName('castle:'. $this->getName());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = parent::execute($input, $output);

        if (empty($result)) {
            $this->getContainer()->get('logger')->info(sprintf('Consumed %s messages', $input->getOption('messages')));
        }

        return $result;
    }
}
