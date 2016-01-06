<?php

namespace Rshief\Bundle\Kal3aBundle\Command;

use Carbon\Carbon;
use Doctrine\ORM\Query;
use DrQue\PolynomialRegression;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CalculateTrendsCommand
 * @package Rshief\Bundle\Kal3aBundle\Command
 */
class CalculateTrendsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    public function configure()
    {
        $this->setName('rshief:trends:calculate')
            ->addArgument('date', InputArgument::OPTIONAL, 'Date', Carbon::now(new \DateTimeZone('UTC'))->modify('-1 day'))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Doctrine\DBAL\Connection $conn */
        $conn = $this->getContainer()->get('database_connection');

        $sql = "SELECT DISTINCT tag FROM tag_statistics ORDER BY tag";
        $stmt = $conn->query($sql); // Simple, but has several drawbacks

        $stmt->execute();

        $tags = array_map(function ($input) { return reset($input); }, $stmt->fetchAll(\PDO::FETCH_NUM));

        $sql = "SELECT * FROM tag_statistics WHERE tag = ? ORDER BY timestamp";
        $stmt = $conn->prepare($sql);

        foreach ($tags as $tag) {
            $stmt->bindValue(1, $tag);
            $stmt->execute();
            $results = $stmt->fetchAll();
            $count = 0;
            if (count($results) > 2) {
                $regression = new PolynomialRegression();
                foreach ($results as $result) {
                    $count += $result['sum'];
                    $regression->addData(Carbon::createFromFormat('Y-m-d H:i:s', $result['timestamp'])->timestamp, $result['sum']);
                }
                $coefficients = $regression->getCoefficients();
                $slope = round( $coefficients[ 1 ], 2 );
                $y_int = round( $coefficients[ 0 ], 2 );
                $conn->insert('tag_trend', array(
                    'tag' => $tag,
                    'slope' => $slope,
                    'count' => $count,
                ));
            }
        }
    }
}
