<?php

namespace Bangpound\Bundle\CastleBundle\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\CouchDB\CouchDBClient;

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
            ->addArgument('dbname', InputArgument::REQUIRED, 'Database connection name')
            ->addArgument('designdoc', InputArgument::REQUIRED, 'Design document name')
            ->addArgument('view', InputArgument::REQUIRED, 'View name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dbname = $input->getArgument('dbname');
        $designdoc = $input->getArgument('designdoc');
        $view = $input->getArgument('view');

        /** @var \Doctrine\CouchDB\CouchDBClient $client */
        $client = $this->registry->getConnection($dbname);

        $query = $client->createViewQuery($designdoc, $view);
        $ret = $query->execute();
        $output->writeln('Updated');

    }

    public function setRegistry(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }
}
