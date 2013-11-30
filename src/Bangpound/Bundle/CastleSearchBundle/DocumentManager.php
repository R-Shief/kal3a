<?php

namespace Bangpound\Bundle\CastleSearchBundle;

use Bangpound\Bundle\CastleSearchBundle\View\ListQuery;

/**
 * Class DocumentManager
 * @package Bangpound\Bundle\CastleSearchBundle
 */
class DocumentManager extends \Doctrine\ODM\CouchDB\DocumentManager {

    /**
     * Create a Native query for the view of the specified design document.
     *
     * A native query will return an array of data from the &include_docs=true parameter.
     *
     * @param  string $designDocName
     * @param  string $viewName
     * @param  string $listName
     * @return ListQuery
     */
    public function createNativeListQuery($designDocName, $viewName, $listName)
    {
        $designDoc = $this->getConfiguration()->getDesignDocument($designDocName);
        if ($designDoc) {
            $designDoc = new $designDoc['className']($designDoc['options']);
        }
        $query = new ListQuery($this->getCouchDBClient()->getHttpClient(), $this->getCouchDBClient()->getDatabase(), $designDocName, $viewName, $listName, $designDoc);
        return $query;
    }
}