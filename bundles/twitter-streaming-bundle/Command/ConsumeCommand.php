<?php

namespace Bangpound\Bundle\TwitterStreamingBundle\Command;

use Bangpound\Bundle\TwitterStreamingBundle\Stream\DoctrineStream;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumeCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('phirehose:consume:basic');
        $this->setDescription('Consume Tweets from firehose');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $stream DoctrineStream  */
        $stream = $this->getContainer()->get('bangpound_phirehose.stream');
        $stream->checkFilterPredicates();
        $stream->consume(false);
    }
}
