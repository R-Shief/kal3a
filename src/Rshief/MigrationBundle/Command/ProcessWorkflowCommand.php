<?php

namespace Rshief\MigrationBundle\Command;

use Ddeboer\DataImport\ItemConverter\CallbackItemConverter;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
use Ddeboer\DataImport\Writer\CallbackWriter;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Source\HttpSource;
use Ddeboer\DataImport\Source\Filter\Unzip;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ProcessWorkflowCommand
 * @package Rshief\MigrationBundle\Command
 */
class ProcessWorkflowCommand extends ContainerAwareCommand {

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('migrate:workflow:process');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    function execute(InputInterface $input, OutputInterface $output) {
        // @todo make $name into a command line argument..
        $name = 'vbulletinpost';

        /** @var \Ddeboer\DataImport\Reader\ReaderInterface $reader */
        $reader = $this->getContainer()->get('rshief_migration.'. $name .'.reader');

        /** @var \Ddeboer\DataImport\Workflow $workflow */
        $workflow = $this->getContainer()->get('rshief_migration.'. $name .'.workflow');

        $dateTimeConverter = new DateTimeValueConverter('U');

        /** @var \Doctrine\CouchDB\CouchDBClient $client */
        // This is too presumptious. @todo
        $client = $this->getContainer()->get('doctrine_couchdb.client.default_connection');

        if ($this->getContainer()->hasParameter('rshief_migration.decoda.config')) {
            $decoda_config = $this->getContainer()->getParameter('rshief_migration.decoda.config');
        }

        // Add converters to the workflow
        $workflow
            ->addValueConverter('dateline', $dateTimeConverter)
            ->addMapping('dateline', 'published')

            ->addMapping('title', 'title')
            ->addMapping('pagetext', 'content')

            ->addItemConverter(new CallbackItemConverter(function ($array) use ($decoda_config) {

                // Ideally this would be a service, but because the configuration is
                // passed after the string and the string is a runtime parameter,
                // I don't know how.
                $decoda = new \Decoda\Decoda($array['pagetext'], $decoda_config);
                $decoda->defaults();
                $pagetext = $decoda->parse();

                $array['pagetext'] = $pagetext;

                return $array;
            }))

            ->addWriter(new ConsoleProgressWriter($output, $reader))

            // Use one of the writers supplied with this bundle, implement your own, or use
            // a closure:
            ->addWriter(new CallbackWriter(
                function($item, $originalItem) use ($client) {
                    $id = (string) $originalItem['postid'];
                    $rev = null;

                    $response = $client->findDocument($id);
                    if ($response->status != 404) {
                        $rev = $response->body['_rev'];
                    }

                    list($id, $rev) = $client->putDocument($item, $id, $rev);
                }
            ))
        ;

        // Process the workflow
        $workflow->process();
    }
}