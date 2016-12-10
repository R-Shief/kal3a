<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PruneCommand extends ContainerAwareCommand
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    protected function configure()
    {
        $date = new \DateTime();
        $date->sub(new \DateInterval('P1M'));

        $this
            ->setName('castle:prune')
            ->setDescription('Prune atom entities by date')
            ->addArgument('date', InputArgument::OPTIONAL, 'Prune date', $date->format('Y-m-d'))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $default_client */
        $default_client = $this->getContainer()->get('doctrine_couchdb')->getConnection();

        $date = \DateTime::createFromFormat('Y-m-d', $input->getArgument('date'));
        $limit = 1000;

        // Executing the query without grouping allows the view to be refreshed.
        /** @var $query */
        $query = $default_client->createViewQuery('maint', 'date');
        $output->writeln('Updating view.');
        $query->execute();

        // All other executions will allow stale results.
        $query->setGroup(false);
        $query->setIncludeDocs(false);
        $query->setStale('ok');
        $query->setReduce(false);

        $query->setStartKey(array());
        $query->setEndKey(array((int) $date->format('Y'), (int) $date->format('m'), (int) $date->format('d'), array()));
        $query->setLimit($limit + 1);

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

                $bulk = $default_client->createBulkUpdater();

                foreach ($result as $i => $row) {
                    if ($i < $limit) {
                        $bulk->deleteDocument($row['id'], $row['value']);
                    }
                }

                $result = $bulk->execute();
            }
        } while ($next_start_key);
    }
}
