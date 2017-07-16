<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class AwsS3ListBucketsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('aws:s3:list-buckets')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $s3 = $this->getContainer()->get('aws.s3');
        $buckets = $s3->listBuckets();

        $output->write(Yaml::dump($buckets->toArray(), 8));
    }
}
