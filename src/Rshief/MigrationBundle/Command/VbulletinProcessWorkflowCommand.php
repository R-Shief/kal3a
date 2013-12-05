<?php

namespace Rshief\MigrationBundle\Command;

use Bangpound\Atom\DataBundle\CouchDocument\CategoryType;
use Bangpound\Atom\DataBundle\CouchDocument\ContentType;
use Bangpound\Atom\DataBundle\CouchDocument\LinkType;
use Bangpound\Atom\DataBundle\CouchDocument\SourceType;
use Bangpound\Atom\DataBundle\CouchDocument\TextType;
use Ddeboer\DataImport\Filter\CallbackFilter;
use Ddeboer\DataImport\ItemConverter\CallbackItemConverter;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
use Ddeboer\DataImport\Writer\CallbackWriter;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Rshief\MigrationBundle\Compiler\TemplateDecompiler;

/**
 * Class VbulletinProcessWorkflowCommand
 * @package Rshief\MigrationBundle\Command
 */
class VbulletinProcessWorkflowCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('migrate:vbulletin:process')
            ->addOption('max-results', null, InputOption::VALUE_REQUIRED)
            ->addOption('first-result', null, InputOption::VALUE_REQUIRED)
        ;
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
//        xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
//        register_shutdown_function(function () {
//            $xhprof_data = xhprof_disable();
//            $xhprof_runs = new \XHProfRuns_Default('/tmp');
//            $runId = $xhprof_runs->save_run($xhprof_data, "Symfony");
//            var_dump($runId);
//        });

        // @todo make $name into a command line argument..
        $name = 'vbulletinpost';

        /** @var \Ddeboer\DataImport\Reader\ReaderInterface $reader */
        $reader = $this->getContainer()->get(sprintf('rshief_migration.%s.reader', $name));
        $reader->setMaxResults($input->getOption('max-results'));
        $reader->setFirstResult($input->getOption('first-result'));

        /** @var \Ddeboer\DataImport\Workflow $workflow */
        $workflow = $this->getContainer()->get(sprintf('rshief_migration.%s.workflow', $name));

        /** @var \Ddeboer\DataImport\Writer\WriterInterface $writer */
        $writer = $this->getContainer()->get(sprintf('rshief_migration.%s.writer', $name));

        $dateTimeConverter = new DateTimeValueConverter('U');

        /** @var \Doctrine\CouchDB\CouchDBClient $client */
        // This is too presumptious. @todo
        $client = $this->getContainer()->get('doctrine_couchdb.client.default_connection');

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $dm = $this->getContainer()->get('doctrine_couchdb.odm.document_manager');

        $repository = $em->getRepository('Rshief\MigrationBundle\Entity\VBulletinRssFeed');
        $templates = array();
        foreach ($repository->findAll() as $rssfeed) {
            $em->detach($rssfeed);
            $regex = TemplateDecompiler::compile($rssfeed->getBodytemplate());
            $templates[$rssfeed->getForumid()][$rssfeed->getUserid()] = $regex['regex'];
        }

        if ($this->getContainer()->hasParameter('rshief_migration.decoda.config')) {
            $decoda_config = $this->getContainer()->getParameter('rshief_migration.decoda.config');
        }

        $contentConstructConverter = new CallbackValueConverter(function ($input) {
            $construct = new ContentType();
            $construct->setType('html');
            $construct->setContent($input);

            return $construct;
        });

        $textConstructConverter = new CallbackValueConverter(function ($input) {
            $construct = new TextType();
            $construct->setText($input);

            return $construct;
        });

        $generateAtomId = function ($key) {
            return 'tag:vbulletin/'. $key;
        };

        // Add converters to the workflow
        $workflow
            ->addFilter(new CallbackFilter(function ($data) use ($generateAtomId, $em, $dm) {
                $repository = $dm->getRepository('Rshief\MigrationBundle\CouchDocument\AtomEntry');
                $existing = $repository->findOneBy(['id' => $generateAtomId($data['postid'])]);
                if ($existing) {
                    $dm->detach($existing);

                    return false;
                }

                return true;
            }))
            ->addValueConverter('dateline', $dateTimeConverter)
            ->addMapping('dateline', 'published')

            ->addMapping('postid', 'id')

            ->addMapping('title', 'title')
            ->addMapping('pagetext', 'content')

            ->addValueConverter('summary', $textConstructConverter)
            ->addValueConverter('title', $textConstructConverter)
            ->addValueConverter('rights', $textConstructConverter)

            // This converter adds an atom ID.
            ->addValueConverter('postid', new CallbackValueConverter(function ($input) use ($generateAtomId) {
                return $generateAtomId($input);
            }))

            ->addValueConverter('pagetext', $contentConstructConverter)

            // This converter replaces reverses the template output to extract original link
            // and description fields.
            ->addItemConverter(new CallbackItemConverter(function ($array) use ($em, $templates) {

                $array['originalData'] = $array;
                $array['links'] = array();
                $array['categories'] = array();

                $repository = $em->getRepository('Rshief\MigrationBundle\Entity\VBulletinThread');
                $thread = $repository->find($array['threadid']);
                $em->detach($thread);
                $forum = $thread->getForum();
                $em->detach($forum);

                $userid = $array['userid'];
                $forumid = $forum->getForumid();

                $template = isset($templates[$forumid][$userid]) ? $templates[$forumid][$userid] : null;

                if ($template) {

                    // Normalize line endings for more reliable matching against templates.
                    $pagetext = preg_replace('~\R~u', "\r\n", $array['pagetext']);

                    $matches = array();
                    preg_match($template, $pagetext, $matches);
                    if (!empty($matches)) {
                        foreach ($matches as $key => $value) {
                            if (!is_int($key)) {
                                switch ($key) {

                                    case 'feedlink':
                                        $link = new LinkType();
                                        $link->setHref($value);
                                        $link->setRel('alternate');
                                        $array['links'][] = $link;
                                        break;

                                    case 'feeddescription':
                                        $array['summary'] = $value;
                                        break;

                                    default:
                                        $array[$key] = $value;
                                        break;

                                }
                            }
                        }
                    }
                }

                return $array;
            }))

            // This converter sets the source on the atom entity.
            ->addItemConverter(new CallbackItemConverter(function ($array) use ($em) {

                $repository = $em->getRepository('Rshief\MigrationBundle\Entity\VBulletinThread');
                $thread = $repository->find($array['threadid']);
                $em->detach($thread);
                $forum = $thread->getForum();

                $userid = $array['userid'];
                $forumid = $forum->getForumid();

                $repository = $em->getRepository('Rshief\MigrationBundle\Entity\VBulletinRssFeed');

                // This is imperfect because a few feds were being imported with the same
                // user and destination $feeds
                // @todo confirm the validity of using the first result among several.
                /** @var \Rshief\MigrationBundle\Entity\VBulletinRssFeed $feed */
                $feed = $repository->findOneBy([
                    'forumid' => $forumid,
                    'userid' => $userid,
                ]);

                if ($feed) {
                    $em->detach($feed);
                    $source = new SourceType();

                    $title = new TextType();
                    $title->setText($feed->getTitle());

                    $source->setTitle($title);

                    $link = new LinkType();
                    $link->setHref($feed->getUrl());

                    $source->addLink($link);

                    $array['source'] = $source;
                }

                return $array;
            }))

            // This converter removes all BBCode.
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

            // This extracts hashtags and URLs where possible.
            ->addItemConverter(new CallbackItemConverter(function ($array) {
                $extractor = new \Twitter_Extractor($array['pagetext']);
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
                    $array['links'][] = $link;
                }

                return $array;
            }))

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
