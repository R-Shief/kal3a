<?php

namespace Rshief\MigrationBundle\Command;

use Bangpound\Atom\DataBundle\CouchDocument\LinkType;
use Ddeboer\DataImport\ItemConverter\CallbackItemConverter;
use Ddeboer\DataImport\Writer\CallbackWriter;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Rshief\MigrationBundle\Compiler\TemplateDecompiler;

/**
 * Class ProcessWorkflowCommand
 * @package Rshief\MigrationBundle\Command
 */
class ProcessWorkflowCommand extends ContainerAwareCommand
{
    private $templates;

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('migrate:workflow:process');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
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

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $repository = $em->getRepository('Rshief\MigrationBundle\Entity\VBulletinRssFeed');
        foreach ($repository->findAll() as $rssfeed) {
            $regex = \Rshief\MigrationBundle\Compiler\TemplateDecompiler::compile($rssfeed->getBodytemplate());
            $this->templates[$rssfeed->getForumid()][$rssfeed->getUserid()] = $regex['regex'];
        }

        $templates = $this->templates;

        if ($this->getContainer()->hasParameter('rshief_migration.decoda.config')) {
            $decoda_config = $this->getContainer()->getParameter('rshief_migration.decoda.config');
        }

        // Add converters to the workflow
        $workflow
            ->addValueConverter('dateline', $dateTimeConverter)
            ->addMapping('dateline', 'published')

            ->addMapping('title', 'title')
            ->addMapping('pagetext', 'content')
            ->addItemConverter(new CallbackItemConverter(function ($array) use ($em, $templates) {

                $repository = $em->getRepository('Rshief\MigrationBundle\Entity\VBulletinThread');
                $thread = $repository->find($array['threadid']);
                $forum = $thread->getForum();

                $userid = $array['userid'];
                $forumid = $forum->getForumid();

                $template = isset($templates[$forumid][$userid]) ? $templates[$forumid][$userid] : '';

                if (!empty($template)) {
                    $matches = array();

                    preg_match($template, $array['pagetext'], $matches);
                    if (!empty($matches)) {
                        foreach ($matches as $key => $value) {
                            if (!is_int($key)) {
                                $array[$key] = $value;
                            }
                        }
                    }
                }

                return $array;
            }))

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
