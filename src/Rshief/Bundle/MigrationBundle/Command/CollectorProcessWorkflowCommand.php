<?php

namespace Rshief\Bundle\MigrationBundle\Command;

use Bangpound\Atom\DataBundle\CouchDocument\CategoryType;
use Bangpound\Atom\DataBundle\CouchDocument\ContentType;
use Bangpound\Atom\DataBundle\CouchDocument\LinkType;
use Bangpound\Atom\DataBundle\CouchDocument\PersonType;
use Bangpound\Atom\DataBundle\CouchDocument\SourceType;
use Bangpound\Atom\DataBundle\CouchDocument\TextType;
use Ddeboer\DataImport\Filter\CallbackFilter;
use Ddeboer\DataImport\ItemConverter\CallbackItemConverter;
use Ddeboer\DataImport\ItemConverter\MappingItemConverter;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
use Ddeboer\DataImport\Writer\CallbackWriter;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CollectorProcessWorkflowCommand
 * @package Rshief\Bundle\MigrationBundle\Command
 */
class CollectorProcessWorkflowCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('migrate:collector:process')
            ->addArgument('table', InputArgument::REQUIRED, 'Database table')
            ->addOption('limit', null, InputOption::VALUE_REQUIRED, 'Limit', 1000)
            ->addOption('offset', null, InputOption::VALUE_REQUIRED, 'Offset', 0)
        ;
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // @todo make $name into a command line argument..
        $name = 'collector';

        /** @var \Doctrine\DBAL\Connection $conn */
        $conn = $this->getContainer()->get(sprintf('doctrine.dbal.%s_connection', $name));

        /** @var \Rshief\Bundle\MigrationBundle\Writer\DoctrineWriter $writer */
        $writer = $this->getContainer()->get(sprintf('rshief_migration.%s.writer', $name));

        /** @var \Ddeboer\DataImport\Reader\ReaderInterface $reader */
        $readerClass = $this->getContainer()->getParameter(sprintf('rshief_migration.%s.reader.class', $name));
        $table = $input->getArgument('table');
        $query = $conn->createQueryBuilder()
            ->select('t.twitter_id', 't.profile_image_url', 't.text', 't.from_user', 't.from_user_id', 't.geo',
                't.language', 't.to_user', 't.to_user_id', 't.source', 't.created_at')
            ->from($table, 't')
            ->orderBy('t.twitter_id')
            ->setFirstResult($input->getOption('offset'))
            ->setMaxResults($input->getOption('limit'));
        $reader = new $readerClass($conn, $query->getSQL());

        /** @var \Ddeboer\DataImport\Workflow $workflow */
        $workflowClass = $this->getContainer()->getParameter(sprintf('rshief_migration.%s.workflow.class', $name));
        $workflow = new $workflowClass($reader);
        $workflow->addWriter($writer);

        $dateTimeConverter = new DateTimeValueConverter('Y-m-d H:i:s');

        /** @var \Doctrine\CouchDB\CouchDBClient $client */
        // This is too presumptious. @todo
        $client = $this->getContainer()->get('doctrine_couchdb.client.default_connection');

        $dm = $this->getContainer()->get('doctrine_couchdb.odm.document_manager');

        $contentConstructConverter = new CallbackValueConverter(function ($input) {
            $construct = new ContentType();
            $construct->setContent($input);

            return $construct;
        });

        $textConstructConverter = new CallbackValueConverter(function ($input) {
            $construct = new TextType();
            $construct->setText($input);

            return $construct;
        });

        $generateAtomId = function ($data) {
            $created_at = \DateTime::createFromFormat('Y-m-d H:i:s', isset($data['created_at']) ? $data['created_at'] : $data['published'], new \DateTimeZone('UTC'));
            $tweet_path = $data['from_user'].'/status/'. $data['twitter_id'];
            $id = 'tag:twitter.com,'. $created_at->format('Y-m-d') .':/'. $tweet_path;

            return $id;
        };

        // Add converters to the workflow
        $workflow
            ->addItemConverter(new MappingItemConverter(array(
                    'created_at' => 'published',
                    'text' => 'title',
                    'language' => 'lang',
                )))

            // This converter adds an atom ID.
            ->addItemConverter(new CallbackItemConverter(
                    function ($array) use ($generateAtomId, $contentConstructConverter) {
                        $array['id'] = $generateAtomId($array);

                        $content = new ContentType();
                        $content->setContent($array['title']);
                        $array['content'] = $content;

                        $array['links'] = array();
                        $array['categories'] = array();
                        $array['authors'] = array();

                        return $array;
                    }
                )
            )

            // This converter fills in Twittery details.
            ->addItemConverter(new CallbackItemConverter(function ($array) {
                    $author = new PersonType();
                    $author->setName($array['from_user']);
                    $array['authors'][] = $author;

                    $link = new LinkType();
                    $link->setHref('https://twitter.com/intent/user?user_id='. $array['from_user_id']);
                    $link->setRel('author');
                    $array['links'][] = $link;

                    $link = new LinkType();
                    $link->setHref(strtr($array['profile_image_url'], ['_normal' => '']));
                    $link->setRel('author thumbnail');
                    $array['links'][] = $link;

                    $link = new LinkType();
                    $link->setHref('http://twitter.com/'.$array['from_user'].'/status/'. $array['twitter_id']);
                    $link->setRel('canonical');
                    $array['links'][] = $link;

                    return $array;
                }))

            // This converter sets the source on the atom entity.
            ->addItemConverter(new CallbackItemConverter(function ($array) {
                    $source = new SourceType();
                    $title = new TextType();
                    $title->setText('Twitter');
                    $source->setTitle($title);
                    $array['source'] = $source;

                    return $array;
                }))

            // This extracts hashtags and URLs where possible.
            ->addItemConverter(new CallbackItemConverter(function ($array) {
                    $extractor = new \Twitter_Extractor($array['title']);
                    $values = $extractor->extract();

                    foreach ($values['hashtags'] as $hashtag) {
                        $category = new CategoryType();
                        $category->setTerm($hashtag);
                        $array['categories'][] = $category;
                    }

                    foreach ($values['urls'] as $url) {
                        $href = html_entity_decode($url);
                        foreach ($array['links'] as $link) {
                            // This prevents duplicate links.
                            if ($href == $link->getHref()) {
                                continue 2;
                            }
                        }
                        $link = new LinkType();
                        $link->setHref($href);
                        $link->setRel('shortlink');
                        $array['links'][] = $link;
                    }

                    return $array;
                }))

            ->addValueConverter('published', $dateTimeConverter)

            ->addValueConverter('title', $textConstructConverter)

            // Use one of the writers supplied with this bundle, implement your own, or use
            // a closure:
            ->addWriter(new ConsoleProgressWriter($output, $reader))

            /**
             * Boilerplate
             *
             * ->addWriter(new CallbackWriter(
             * function ($item, $originalItem) use ($client) {
             * list($id, $rev) = $client->putDocument($item, $id, $rev);
             * }
             * ))
             */
        ;

        // Process the workflow
        $workflow->process();
    }
}
