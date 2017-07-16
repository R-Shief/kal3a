<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
          ->setName('app:migrate')
          ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit', 100)
          ->addOption('start', 's', InputOption::VALUE_REQUIRED, 'Start key', null)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $couchDBClient = $this->getContainer()->get('couchdb_connection');
        $info = $couchDBClient->getDatabaseInfo();

        $limit = $input->getOption('limit');
        $lastKey = $input->getOption('start');

        $producer = $this->getContainer()->get('old_sound_rabbit_mq.reindex_producer');
        $response = $couchDBClient->allDocs($limit, $lastKey);

        $bar = new ProgressBar($output, $info['doc_count']);
        $bar->setRedrawFrequency($limit);
        $bar->setFormat('%current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s% %message%');

        do {
            if ($response->status !== 200) {
                throw new \RuntimeException("Error while migrating at offset " . $lastKey);
            }

            foreach ($response->body['rows'] as $row) {
                $doc = $row['doc'];
                $newMsg = json_encode($doc);
                $producer->publish($newMsg, '', ['content_type' => 'application/json']);
                $bar->advance();
                $bar->setMessage($lastKey);
                $lastKey = $row['key'];
            }

            $response = $couchDBClient->allDocs($limit, $lastKey);
        } while (count($response->body['rows']) > 1);
        $output->writeln('');
    }
}
