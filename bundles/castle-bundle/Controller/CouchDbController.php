<?php

namespace Bangpound\Bundle\CastleBundle\Controller;

use Doctrine\CouchDB\CouchDBException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CouchDbController extends Controller
{
    /**
     * @return mixed
     * @throws \Doctrine\CouchDB\CouchDBException
     * @Route("/_active_tasks")
     * @Template
     */
    public function tasksAction()
    {
        /** @var \Doctrine\CouchDB\CouchDBClient $conn */
        $conn = $this->get('doctrine_couchdb')->getConnection();

        $response = $conn->getHttpClient()->request('GET', '/_active_tasks');

        if ($response->status != 200) {
            throw new CouchDBException("Could not retrieve active tasks from CouchDB.");
        }

        return array(
          'data' => $response->body,
        );
    }
}
