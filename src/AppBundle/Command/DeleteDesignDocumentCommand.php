<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteDesignDocumentCommand extends ContainerAwareCommand
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    protected function configure()
    {
        $this
            ->setName('castle:design-document:delete')
            ->setDescription('Update a view')
            ->addOption('dm', null, InputOption::VALUE_OPTIONAL, 'The document manager to use for this command', 'default')
            ->addArgument('designdoc', InputArgument::REQUIRED, 'Design document name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $dbname */
        $dbname = $input->getOption('dm');
        /** @var string $designdoc */
        $designdoc = $input->getArgument('designdoc');

        /** @var \Doctrine\CouchDB\CouchDBClient $client */
        $client = $this->getContainer()->get('doctrine_couchdb')->getConnection($dbname);

        $document = $client->findDocument('_design/'. $designdoc);
        $client->deleteDocument('_design/'. $designdoc, $document->body['_rev']);
        $output->writeln('Deleted');
    }

    public function setRegistry(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }
}
