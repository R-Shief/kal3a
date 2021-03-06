<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends ContainerAwareCommand
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    protected function configure()
    {
        $this
            ->setName('castle:export')
            ->setDescription('Export atom entities by tag and date')
            ->addArgument('tag', InputArgument::REQUIRED, 'Which tag to export?')
            ->addArgument('start', InputArgument::REQUIRED, 'Start date')
            ->addArgument('end', InputArgument::REQUIRED, 'End date')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Output file')
            ->addOption('stale', 'stale', InputOption::VALUE_NONE, 'Stale')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $default_client */
        $default_client = $this->getContainer()->get('doctrine_couchdb')->getConnection();

        $tag = $input->getArgument('tag');
        $outputFile = $input->getOption('output');
        $start = \DateTime::createFromFormat('Y-m-d', $input->getArgument('start'));
        $end = \DateTime::createFromFormat('Y-m-d', $input->getArgument('end'));
        $limit = 1000;

        // Executing the query without grouping allows the view to be refreshed.
        /** @var $query */
        $query = $default_client->createViewQuery('maint', 'tag');
        if ($input->getOption('stale') !== 'ok') {
            $output->writeln('Updating view.');
            $query->execute();
        }

        // All other executions will allow stale results.
        $query->setGroup(false);
        $query->setIncludeDocs(true);
        $query->setStale('ok');
        $query->setReduce(false);

        $query->setStartKey([$tag, (int) $start->format('Y'), (int) $start->format('m'), (int) $start->format('d')]);
        $query->setEndKey([$tag, (int) $end->format('Y'), (int) $end->format('m'), (int) $end->format('d')]);
        $query->setLimit($limit + 1);

        file_put_contents($outputFile, '[');

        do {
            $result = $query->execute();
            $next_start_key = null;
            if (count($result) > 0) {
                if (count($result) == $limit + 1) {
                    $next_start_key = $result[$limit]['key'];
                    $query->setStartKey($result[$limit]['key']);
                    $query->setStartKeyDocId($result[$limit]['id']);
                    $output->writeln('resume with '.implode('-', $result[$limit]['key']).' '.$result[$limit]['id']);
                }

                $rows = array();
                foreach ($result as $i => $row) {
                    if ($i < $limit) {
                        $rows[] = json_encode($row['doc']);
                    }
                }
                $data = implode(',', $rows);
                if ($next_start_key) {
                    $data .= ',';
                }
                file_put_contents($outputFile, $data, FILE_APPEND | LOCK_EX);
            }
        } while ($next_start_key);

        file_put_contents($outputFile, ']', FILE_APPEND | LOCK_EX);
    }
}
