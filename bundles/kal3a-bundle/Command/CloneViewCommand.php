<?php

namespace Rshief\Bundle\Kal3aBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\CouchDB\CouchDBClient;

/**
 * Class CopyTrendsCommand
 * @package Rshief\Bundle\Kal3aBundle\Command
 */
class CloneViewCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    public function configure()
    {
        $date = new \DateTime();

        $this->setName('rshief:trends:clone-view')
            ->addArgument('start', InputArgument::OPTIONAL, 'Start date', $date->format('Y-m-d'))
            ->addArgument('end', InputArgument::OPTIONAL, 'End date')
            ->addArgument('design_document', InputArgument::OPTIONAL, 'Design document', 'tag_trends')
            ->addArgument('view_name', InputArgument::OPTIONAL, 'View name', 'PT1M')
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $default_client */
        $default_client = $this->getContainer()->get('doctrine_couchdb.client.default_connection');
        /** @var \Doctrine\CouchDB\CouchDBClient $stats_client */
        $stats_client = $this->getContainer()->get('doctrine_couchdb.client.stats_connection');

        // DB view arguments
        $design_document = $input->getArgument('design_document');
        $view_name = $input->getArgument('view_name');
        $start = \DateTime::createFromFormat('Y-m-d', $input->getArgument('start'));
        if ($input->getArgument('end')) {
            $end = \DateTime::createFromFormat('Y-m-d', $input->getArgument('end'));
        } else {
            $end = clone $start;
        }

        $limit = 1000;

        // Executing the query without grouping allows the view to be refreshed.
        $query = $default_client->createViewQuery($design_document, $view_name);
        $output->writeln('Updating view.');
        $query->execute();

        // All other executions will allow stale results.
        $query->setGroup(true);
        $query->setStale('ok');

        $output->writeln(sprintf('%s -> %s', $start->format('Y-m-d'), $end->format('Y-m-d')));

        $query->setStartKey([(int) $start->format('Y'), (int) $start->format('m'), (int) $start->format('d') ]);
        $query->setEndKey([(int) $end->format('Y'), (int) $end->format('m'), (int) $end->format('d'), array() ]);
        $query->setLimit($limit + 1);

        do {
            /** @var \Doctrine\CouchDB\View\Result $result */
            $result = $query->execute();
            /** @var \Doctrine\CouchDB\Utils\BulkUpdater $bulk */
            $bulk = $stats_client->createBulkUpdater();
            $next_start_key = null;
            if (count($result) > 0) {
                $max = count($result) > $limit ? $limit : count($result);
                $max_key = count($result) > $limit ? $limit - 1 : count($result) - 1;
                $output->writeln(sprintf('%s -> %s', $result[0]['key'][5], $result[$max_key]['key'][5]));

                if (count($result) == $limit + 1) {
                    $next_start_key = $result[$limit]['key'];
                }

                // Predict IDs for all rows in this batch.
                $ids = array();
                foreach ($result as $row) {
                    $ids[] = $this->generateId($design_document, $view_name, $row['key']);
                }

                // Query for the revision IDs of any existing documents with the same keys.
                $results = $stats_client->getHttpClient()->request('POST', '/' . $stats_client->getDatabase() . '/_all_docs',
                    json_encode(
                        array('keys' => array_values($ids))
                    )
                );

                $rev_map = array();
                foreach ($results->body['rows'] as $row) {
                    if (!isset($row['error'])) {
                        $rev_map[$row['id']] = $row['value']['rev'];
                    }
                }

                $bulk = $stats_client->createBulkUpdater();

                foreach ($result as $row) {
                    $document = array();
                    $document['_id'] = $id = $this->generateId($design_document, $view_name, $row['key']);

                    if (isset($rev_map[$id])) {
                        $document['_rev'] = $rev_map[$id];
                    }

                    $document['tag'] = array_pop($row['key']);

                    $date = new \DateTime();
                    call_user_func_array(array($date, 'setDate'), array_slice($row['key'], 0, 3));
                    call_user_func_array(array($date, 'setTime'), array_slice($row['key'], 3, 2));

                    $document['date'] = $date->format('Y-m-d H:i:s.u');

                    $document['value'] = $row['value']['count'];
                    $bulk->updateDocument($document);
                }
                $result = $bulk->execute();

                $query->setStartKey($next_start_key);
            }
        } while ($next_start_key);
    }

    private function generateId($design_document, $view_name, $key)
    {
        return $design_document .' '. $view_name .' '. implode(' ', $key);
    }
}
