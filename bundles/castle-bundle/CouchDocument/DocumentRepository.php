<?php
/**
 * Created by PhpStorm.
 * User: bjd
 * Date: 10/30/13
 * Time: 8:02 AM
 */

namespace Bangpound\Bundle\CastleBundle\CouchDocument;

use Doctrine\ODM\CouchDB\DocumentManager;
use Doctrine\ODM\CouchDB\DocumentRepository as BaseDocumentRepository;
use Doctrine\ODM\CouchDB\Mapping\ClassMetadata;

class DocumentRepository extends BaseDocumentRepository
{
    /**
     * Initializes a new <tt>DocumentRepository</tt>.
     *
     * @param DocumentManager $dm    The DocumentManager to use.
     * @param ClassMetadata   $class The class descriptor.
     */
//    public function __construct($dm, ClassMetadata $class)
//    {
//        parent::__construct($dm, $class);
//
//        $typeMap = [
//            'twitter' => 'Rshief\TwitterMinerBundle\CouchDocument\AtomEntry',
//            'pubsub' => 'Rshief\PubsubBundle\CouchDocument\AtomEntry',
//            'vbulletin' => 'Rshief\MigrationBundle\CouchDocument\AtomEntry',
//        ];
//
//        $this->documentType = array_search($this->documentName, $typeMap);
//    }
}
