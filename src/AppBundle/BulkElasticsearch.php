<?php

namespace AppBundle;

use AppBundle\Document\AtomEntry;
use ONGR\ElasticsearchBundle\Service\Manager;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Event;

class BulkElasticsearch implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var integer
     */
    private $limit;

    /**
     * @var array
     */
    private $data = [];

    /**
     * BulkConsumer constructor.
     * @param Manager $manager
     * @param $limit
     */
    public function __construct(Manager $manager, $limit)
    {
        $this->manager = $manager;
        $this->limit = $limit;
    }

    public function updateDocument($data)
    {
        $this->data[] = $data;
        $this->maybeExecute();
    }

    /**
     *
     */
    private function maybeExecute()
    {
        if (count($this->data) >= $this->limit) {
            $response = $this->execute();
        }
    }

    /**
     * @return array
     */
    private function execute()
    {
        array_map(function (AtomEntry $entry) {
            $this->manager->persist($entry);
        }, $this->data);
        $response = $this->manager->flush();

        $this->logger->info('added '. $this->limit .' new documents');

        $this->data = [];

        return $response;
    }

    public function onEvent(Event $event)
    {
        if (!empty($this->data)) {
            $response = $this->execute();
        }
    }

    public function __destruct()
    {
        if (!empty($this->data)) {
            $response = $this->execute();
        }
    }
}
