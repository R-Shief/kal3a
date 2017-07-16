<?php

namespace AppBundle\Command;

use OldSound\RabbitMqBundle\Command\ConsumerCommand as BaseConsumerCommand;
use OldSound\RabbitMqBundle\RabbitMq\Consumer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsumerCommand
 * @package AppBundle\Command
 * @property Consumer $consumer
 */
class ConsumerCommand extends BaseConsumerCommand
{
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
