<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\CouchDB\HTTP\Response;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class UpdateViewCommand extends ContainerAwareCommand
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    protected function configure()
    {
        $this
            ->setName('castle:view:update')
            ->setDescription('Update a view')
            ->addOption('dm', null, InputOption::VALUE_OPTIONAL, 'The document manager to use for this command', 'default')
            ->addArgument('designdoc', InputArgument::REQUIRED, 'Design document name')
            ->addArgument('view', InputArgument::OPTIONAL, 'View name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stopwatch = new Stopwatch();
        /** @var string $dbname */
        $dbname = $input->getOption('dm');
        /** @var string $designdoc */
        $designdoc = $input->getArgument('designdoc');
        /** @var string $view */
        $view = $input->getArgument('view');

        /** @var \Doctrine\CouchDB\CouchDBClient $client */
        $client = $this->getContainer()->get('doctrine_couchdb')->getConnection($dbname);
        if (!$view) {
            $ret = $client->findDocument('_design/'.$designdoc);
            $view = key($ret->body['views']);
        }

        $query = $client->createViewQuery($designdoc, $view);
        $stopwatch->start('update');
        $ret = $query->execute();
        $event = $stopwatch->stop('update');
        $output->writeln(sprintf('Updated in %s seconds', $event->getDuration() / 1000));
    }

    public function setRegistry(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }
}
