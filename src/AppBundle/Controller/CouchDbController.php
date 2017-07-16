<?php

namespace AppBundle\Controller;

use Doctrine\CouchDB\CouchDBException;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Response;

class CouchDbController extends Controller
{
    /**
     * @return mixed
     *
     * @throws \Doctrine\CouchDB\CouchDBException
     * @Sensio\Route("/_active_tasks")
     * @Sensio\Template
     * @Sensio\Security("has_role('ROLE_ADMIN')")
     */
    public function tasksAction()
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $conn */
        $conn = $this->get('doctrine_couchdb')->getConnection();

        $response = $conn->getHttpClient()->request('GET', '/_active_tasks');

        if ($response->status !== 200) {
            throw new CouchDBException('Could not retrieve active tasks from CouchDB.');
        }

        return array(
          'data' => $response->body,
        );
    }

    /**
     * CouchDB database API.
     *
     * The Database endpoint provides an interface to an entire database with in
     * CouchDB. These are database-level, rather than document-level requests.
     *
     * * List all design documents with `/_all_docs?startkey="_design"&endkey="_design0"&include_docs=true`
     *
     * Only GET requests are allowed.
     *
     * @Nelmio\ApiDoc(section="CouchDB", requirements={
     *      {"name"="op"}
     * })
     * @FOSRest\Get("/couchdb")
     *
     * @link http://docs.couchdb.org/en/2.0.0/api/database/index.html
     * @param string $op
     * @param ServerRequestInterface $serverRequest
     * @return Response
     */
    public function dbAction($op = null, ServerRequestInterface $serverRequest)
    {
        return $this->forward('bangpound_guzzle_proxy.controller:proxy', [
          'endpoint' => 'couchdb',
          'path' => $op,
          'request' => $serverRequest,
        ]);
    }

    /**
     * CouchDB documents API.
     *
     * For documents and attachments.
     *
     * @param string $doc
     * @param ServerRequestInterface $serverRequest
     * @return Response
     * @internal param string $path
     * @link http://docs.couchdb.org/en/2.0.0/api/document/index.html
     * @Nelmio\ApiDoc(section="CouchDB")
     * @FOSRest\Get("/couchdb/{doc}")
     */
    public function documentAction($doc = null, ServerRequestInterface $serverRequest)
    {
        return $this->forward('bangpound_guzzle_proxy.controller:proxy', [
          'endpoint' => 'couchdb',
          'path' => $doc,
          'request' => $serverRequest,
        ]);
    }

    /**
     * CouchDB design document API.
     *
     * @param string $ddoc
     * @param ServerRequestInterface $serverRequest
     * @return Response
     * @link http://docs.couchdb.org/en/2.0.0/api/ddoc/index.html
     * @Nelmio\ApiDoc(section="CouchDB")
     * @FOSRest\Get("/couchdb/_design/{ddoc}")
     */
    public function designDocumentAction($ddoc = null, ServerRequestInterface $serverRequest)
    {
        return $this->forward('bangpound_guzzle_proxy.controller:proxy', [
          'endpoint' => 'couchdb',
          'path' => '_design/'. $ddoc,
          'request' => $serverRequest,
        ]);
    }
}
