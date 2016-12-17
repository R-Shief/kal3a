<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
            ->addArgument('view', InputArgument::REQUIRED, 'View name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $dbname */
        $dbname = $input->getOption('dm');
        /** @var string $designdoc */
        $designdoc = $input->getArgument('designdoc');
        /** @var string $view */
        $view = $input->getArgument('view');

        /** @var \Doctrine\CouchDB\CouchDBClient $client */
        $client = $this->getContainer()->get('doctrine_couchdb')->getConnection($dbname);

        $query = $client->createViewQuery($designdoc, $view);
        $ret = $query->execute();
        $output->writeln('Updated');
    }

    public function setRegistry(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }
}
