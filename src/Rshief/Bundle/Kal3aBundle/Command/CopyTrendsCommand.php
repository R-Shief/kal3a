<?php

namespace Rshief\Bundle\Kal3aBundle\Command;

use Rshief\Bundle\Kal3aBundle\Entity\TagStatistic;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Carbon\Carbon;

/**
 * Class CopyTrendsCommand
 * @package Rshief\Bundle\Kal3aBundle\Command
 */
class CopyTrendsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    public function configure()
    {
        $this->setName('rshief:trends:copy')
            ->addArgument('design_document', InputArgument::REQUIRED, 'Design document')
            ->addArgument('view_name', InputArgument::REQUIRED, 'View name')
            ->addArgument('date', InputArgument::OPTIONAL, 'Date', Carbon::now(new \DateTimeZone('UTC'))->modify('-1 day'))
            ->addArgument('interval', InputArgument::OPTIONAL, 'Interval', 'P1D')
            ->addArgument('group_level', InputArgument::OPTIONAL, 'Group level', 5)
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $stats_client = $this->getContainer()->get('doctrine_couchdb.client.trends_connection');

        // DB view arguments
        $design_document = $input->getArgument('design_document');
        $view_name = $input->getArgument('view_name');

        // MySQL db entity
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository('Rshief\Bundle\Kal3aBundle\Entity\TagStatistic');

        /** @var \DateTime $date */
        $date = $input->getArgument('date');
        $interval = $input->getArgument('interval');

        $period = 'P1i';

        $limit = 1000;

        // Executing the query without grouping allows the view to be refreshed.
        $query = $stats_client->createViewQuery($design_document, $view_name);
        $output->writeln('Updating view.');
        $query->execute();

        // All other executions will allow stale results.
        $query->setGroup(true);
        $query->setStale('ok');

        $end = clone $date;
        $end->add(new \DateInterval($interval));

        $output->writeln(sprintf('%s -> %s', $date->format('Y-m-d'), $end->format('Y-m-d')));

        $query->setStartKey([(int) $date->format('Y'), (int) $date->format('m'), (int) $date->format('d') ]);
        $query->setEndKey([(int) $end->format('Y'), (int) $end->format('m'), (int) $end->format('d'), array() ]);
        $query->setLimit($limit + 1);

        do {
            $result = $query->execute();
            $next_start_key = null;
            if (count($result) > 0) {
                $max = count($result) > $limit ? $limit : count($result);
                $max_key = count($result) > $limit ? $limit - 1 : count($result) - 1;
                $output->writeln(sprintf('%s -> %s', $result[0]['key'][5], $result[$max_key]['key'][5]));

                if (count($result) == $limit + 1) {
                    $next_start_key = $result[$limit]['key'];
                }

                foreach ($result as $row) {
                    $timestamp = new \Bangpound\DateTime();
                    $timestamp->setDate($row['key'][0], $row['key'][1], $row['key'][2])
                        ->setTime($row['key'][3], $row['key'][4]);

                    $stats = $repository->findOneBy(array(
                        'tag' => $row['key'][5],
                        'period' => $period,
                        'timestamp' => $timestamp,
                    ));

                    $new = TRUE;
                    if ($stats) {
                        $new = FALSE;
                    }

                    if ($new) {
                        $stats = new TagStatistic();
                    }
                    $stats->setCount($row['value']['count'])
                        ->setMax($row['value']['max'])
                        ->setMin($row['value']['min'])
                        ->setSum($row['value']['sum'])
                        ->setSumsqr($row['value']['sumsqr'])
                        ->setPeriod($period)
                        ->setTag($row['key'][5])
                        ->setTimestamp($timestamp);

                    if ($new) {
                        $em->persist($stats);
                    }
                }

                $query->setStartKey($next_start_key);
            }
            $em->flush();
            $em->clear();
        } while ($next_start_key);
    }
}
