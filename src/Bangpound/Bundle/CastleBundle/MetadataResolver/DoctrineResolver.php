<?php
/**
 * Created by PhpStorm.
 * User: bjd
 * Date: 10/30/13
 * Time: 4:10 AM
 */

namespace Bangpound\Bundle\CastleBundle\MetadataResolver;


use Doctrine\ODM\CouchDB\Mapping\ClassMetadata;
use Doctrine\ODM\CouchDB\DocumentManager;
use Doctrine\ODM\CouchDB\PersistentIdsCollection;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ODM\CouchDB\Mapping\MetadataResolver\DoctrineResolver as BaseDoctrineResolver;

/**
 * Class DoctrineResolver
 * @package Bangpound\Bundle\CastleBundle\MetadataResolver
 */
class DoctrineResolver extends BaseDoctrineResolver
{
    private $typeMap;

    public function __construct() {
        $this->typeMap = [
            'twitter' => 'Rshief\TwitterMinerBundle\CouchDocument\AtomEntry',
            'pubsub' => 'Rshief\PubsubBundle\CouchDocument\AtomEntry',
            'vbulletin' => 'Rshief\MigrationBundle\CouchDocument\AtomEntry',
        ];
    }

    /**
     * @param ClassMetadata $class
     * @return array
     */
    public function createDefaultDocumentStruct(ClassMetadata $class)
    {
        $struct = parent::createDefaultDocumentStruct($class);
        $key = array_search($class->name, $this->typeMap);
        if ($key) {
            $struct['type'] = $key;
        }
        return $struct;
    }

    /**
     * @param array $documentData
     * @return mixed
     */
    public function getDocumentType(array $documentData)
    {
        if (in_array($documentData['type'], $this->typeMap)) {
            return $this->typeMap[$documentData['type']];
        }
        else {
            return parent::getDocumentType($documentData);
        }
    }
}
