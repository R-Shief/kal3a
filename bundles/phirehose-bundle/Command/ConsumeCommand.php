<?php

namespace Bangpound\PhirehoseBundle\Command;

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
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Start streaming

        /* @var $stream DoctrineStream  */
        $stream = $this->getContainer()->get('bangpound_phirehose.stream')
            ->setOutput($output);
        $stream->checkFilterPredicates();
        $stream->consume(false);
    }
}
