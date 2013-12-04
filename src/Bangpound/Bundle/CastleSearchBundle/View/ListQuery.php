<?php

namespace Bangpound\Bundle\CastleSearchBundle\View;

use Doctrine\CouchDB\View\Query;
use Doctrine\CouchDB\HTTP\Client;
use Doctrine\CouchDB\View\DesignDocument;

/**
 * Class ListQuery
 * @package Bangpound\Bundle\CastleSearchBundle\View
 */
class ListQuery extends Query
{
    private $listName;

    /**
     * @param Client         $client
     * @param string         $databaseName
     * @param string         $designDocName
     * @param string         $viewName
     * @param string         $listName
     * @param DesignDocument $doc
     * @internal param string $listName
     */
    public function __construct(Client $client, $databaseName, $designDocName, $viewName, $listName, DesignDocument $doc = null)
    {
        parent::__construct($client, $databaseName, $designDocName, $viewName, $doc);
        $this->listName = $listName;
    }

    /**
     * @return string
     */
    protected function getHttpQuery()
    {
        $arguments = array();
        foreach ($this->params as $key => $value) {
            if ($key === 'stale') {
                $arguments[$key] = $value;
            } else {
                $arguments[$key] = json_encode($value);
            }
        }

        return sprintf(
            "/%s/_design/%s/_list/%s/%s?%s",
            $this->databaseName,
            $this->designDocumentName,
            $this->listName,
            $this->viewName,
            http_build_query($arguments)
        );
    }
}
