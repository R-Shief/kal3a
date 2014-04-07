<?php
/**
 * Created by PhpStorm.
 * User: bjd
 * Date: 10/30/13
 * Time: 10:54 AM
 */

namespace Rshief\Bundle\MigrationBundle\Reader;

use Ddeboer\DataImport\Reader\DoctrineReader as BaseDoctrineReader;
use Doctrine\ORM\Query;

class DoctrineReader extends BaseDoctrineReader
{
    private $maxResults = 100;
    private $firstResult = 0;

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        if (!$this->iterableResult) {
            /** @var \Doctrine\ORM\Query $query */
            $query = $this->objectManager->createQuery(
                sprintf('select o from %s o', $this->objectName)
            );
            $query->setMaxResults($this->maxResults);
            $query->setFirstResult($this->firstResult);
            $this->iterableResult = $query->iterate(array(), Query::HYDRATE_ARRAY);
        }

        $this->iterableResult->rewind();
    }

    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }

    public function setFirstResult($firstResult)
    {
        $this->firstResult = $firstResult;
    }
}
