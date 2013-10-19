<?php
namespace Bangpound\Check;

use Doctrine\Bundle\CouchDBBundle\ManagerRegistry;
use Liip\Monitor\Check\Check;
use Liip\Monitor\Result\CheckResult;

/**
 * Class CouchDBCheck
 * @package Bangpound\Check
 */
class CouchDBCheck extends Check {

    /**
     * @var ManagerRegistry
     */
    protected $manager;

    /**
     * @var string
     */
    protected $connectionName;

    /**
     * @param ManagerRegistry $manager
     * @param string $connectionName
     */
    public function __construct(ManagerRegistry $manager, $connectionName = 'default')
    {
        $this->manager = $manager;
        $this->connectionName = $connectionName;
    }

    /**
     * @return \Liip\Monitor\Result\CheckResult
     */
    public function check()
    {
        try {
            $connection = $this->manager->getConnection($this->connectionName);
            $version = $connection->getVersion();
            $result = $this->buildResult('OK', CheckResult::OK);
        } catch (\Exception $e) {
            $result = $this->buildResult($e->getMessage(), CheckResult::CRITICAL);
        }

        return $result;
    }

    public function getName()
    {
        return 'Doctrine CouchDB connection';
    }
}
