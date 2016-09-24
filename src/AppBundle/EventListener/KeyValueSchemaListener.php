<?php

namespace AppBundle\EventListener;

use AppBundle\Doctrine\DbalStoreSchema;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

class KeyValueSchemaListener
{
    /**
     * @var DbalStoreSchema
     */
    private $schema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    public function postGenerateSchema(GenerateSchemaEventArgs $args)
    {
        $schema = $args->getSchema();
        $this->schema->addToSchema($schema);
    }
}
