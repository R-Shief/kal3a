<?php

namespace AppBundle;

use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\HTTP\ErrorResponse;
use Doctrine\CouchDB\HTTP\HTTPException;
use Doctrine\CouchDB\HTTP\Response;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Event;

class BulkCouchDB implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var CouchDBClient
     */
    private $client;

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
     * @param CouchDBClient $client
     * @param $limit
     */
    public function __construct(CouchDBClient $client, $limit)
    {
        $this->client = $client;
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
     * @return Response
     */
    private function execute()
    {
        $bulkUpdater = $this->client->createBulkUpdater();
        $bulkUpdater->updateDocuments($this->data);
        $response = $bulkUpdater->execute();



        // Semantics of response status are special on bulk updates.
        if ($response->status === 201 || $response->status === 417) {
            /** @var array $ok_docs */
            $ok_docs = array_filter($response->body, function ($doc) {
                return isset($doc['rev']);
            });

            /** @var array $bad_docs */
            $bad_docs = array_filter($response->body, function ($doc) {
                return !isset($doc['rev']);
            });

            $this->logger->info('added '. count($ok_docs) .' new documents');
            if (count($ok_docs)) {
                foreach ($ok_docs as $key => $res) {
                    $this->logger->debug('created new document', $res);
                }
            }

            if (count($bad_docs)) {
                $this->logger->error('failed '. count($bad_docs) .' new documents');
                // $key here is the same index as the original source list, so we could
                // later resend those documents to the queue.
                foreach ($bad_docs as $key => $res) {
                    $er = new ErrorResponse($response->status, $response->headers, $res);
                    $e = HTTPException::fromResponse($bulkUpdater->getPath(), $er);
                    $this->logger->info($e->getMessage());
                }
            }
        }

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

    //    private function nothing() {
//        try {
//            $result = $this->client->postDocument($data);
//
//            return ConsumerInterface::MSG_ACK;
//        } catch (HTTPException $e) {
//            $this->logger->error($e->getMessage());
//
//            return ConsumerInterface::MSG_REJECT_REQUEUE;
//        }
//    }
}
