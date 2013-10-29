<?php

namespace Rshief\TwitterMinerBundle\Logger;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\Types\Type;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class DBALHandler extends AbstractProcessingHandler
{
    private $initialized = false;
    private $connection;

    /** @var Statement */
    private $statement;

    public function __construct(Connection $connection, $level = Logger::DEBUG, $bubble = true)
    {
        $this->connection = $connection;
        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $record)
    {
        if ($record['channel'] != 'twitter_data') {
            return false;
        }

        return parent::handle($record);
    }

    protected function write(array $record)
    {
        if (!$this->initialized) {
            $this->initialize();
        }
        $this->statement->bindValue('channel', $record['channel'], Type::STRING);
        $this->statement->bindValue('level', $record['level'], Type::INTEGER);
        $this->statement->bindValue('level_name', $record['level_name'], Type::STRING);
        $this->statement->bindValue('message', $record['message'], Type::TEXT);
        $this->statement->bindValue('context', $record['context'], Type::TARRAY);
        $this->statement->bindValue('extra', $record['extra'], Type::TARRAY);
        $this->statement->bindValue('datetime', $record['datetime'], Type::DATETIME);

        $this->statement->execute();
    }

    private function initialize()
    {
        $schemaManager = $this->connection->getSchemaManager();
        if (!$schemaManager->tablesExist(array('monolog'))) {
            $table = new Table('monolog');
            $table->addColumn("channel", "string", array("length" => 255));
            $table->addColumn("level", "integer");
            $table->addColumn("level_name", "string", array("length" => 255));
            $table->addColumn("message", "text");
            $table->addColumn("context", "array");
            $table->addColumn("extra", "array");
            $table->addColumn("datetime", "datetime");
            $schemaManager->createTable($table);
        }

        $this->statement = $this->connection->prepare(
            'INSERT INTO monolog (channel, level, level_name, message, '
             .'context, extra, datetime) VALUES (:channel, :level, '
             .':level_name, :message, :context, :extra, :datetime)'
        );

        $this->initialized = true;
    }
}
