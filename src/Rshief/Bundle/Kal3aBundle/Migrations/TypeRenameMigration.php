<?php

namespace Rshief\Bundle\Kal3aBundle\Migrations;

use Doctrine\CouchDB\Tools\Migrations\AbstractMigration;
use Doctrine\ODM\CouchDB\Migrations\DocumentMigration;

/**
 * Class TypeRenameMigration
 * @package Rshief\Bundle\Kal3aBundle\Migrations
 */
class TypeRenameMigration extends AbstractMigration implements DocumentMigration
{
    /**
     * Accept a CouchDB document and migrate data, return new document.
     *
     * This method has to return null (or nothing) when no migration
     * needs to take place.
     *
     * @param  array $data
     * @return array
     */
    public function migrate(array $data)
    {
        if (isset($data['type']) && 'Rshief.TwitterMinerBundle.CouchDocument.AtomEntry' === $data['type']) {
            $data['type'] = 'Bangpound.Bundle.TwitterStreamingBundle.CouchDocument.AtomEntry';

            return $data;
        }
    }
}
