<?php

namespace AppBundle\Doctrine;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;

final class DbalStoreSchema extends Schema
{
    /**
     * @var Table
     */
    private $table;

    public function addToSchema(Schema $schema)
    {
        $schema->_addTable($this->table);
    }

    public function setTable(Table $table)
    {
        $this->table = $table;
    }
}
