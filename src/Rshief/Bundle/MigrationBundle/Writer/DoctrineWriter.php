<?php

namespace Rshief\Bundle\MigrationBundle\Writer;

use Ddeboer\DataImport\Writer\AbstractWriter;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * A bulk Doctrine writer
 *
 * See also the {@link http://www.doctrine-project.org/docs/orm/2.1/en/reference/batch-processing.html Doctrine documentation}
 * on batch processing.
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class DoctrineWriter extends AbstractWriter
{
    /**
     * Doctrine entity manager
     *
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Fully qualified class name
     *
     * @var string
     */
    protected $className;

    /**
     * Doctrine object repository
     *
     * @var ObjectRepository
     */
    protected $objectRepository;

    /**
     * @var ClassMetadata
     */
    protected $classMetadata;

    /**
     * Number of entities to be persisted per flush
     *
     * @var int
     */
    protected $batchSize = 20;

    /**
     * Counter for internal use
     *
     * @var int
     */
    protected $counter = 0;

    /**
     * Whether to truncate the table first
     *
     * @var boolean
     */
    protected $truncate = true;

    /**
     *
     * @param ObjectManager $objectManager
     * @param string        $className
     * @param string        $index         Index to find current entities by
     */
    public function __construct(ObjectManager $objectManager, $className, $index = null)
    {
        $this->objectManager = $objectManager;
        $this->className = $className;
        $this->objectRepository = $objectManager->getRepository($className);
        $this->classMetadata = $objectManager->getClassMetadata($className);
        $this->index = $index;
    }

    /**
     * @return int
     */
    public function getBatchSize()
    {
        return $this->batchSize;
    }

    /**
     * Set number of entities that may be persisted before a new flush
     *
     * @param  int            $batchSize
     * @return DoctrineWriter
     */
    public function setBatchSize($batchSize)
    {
        $this->batchSize = $batchSize;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTruncate()
    {
        return $this->truncate;
    }

    /**
     * @param $truncate
     * @return $this
     */
    public function setTruncate($truncate)
    {
        $this->truncate = $truncate;

        return $this;
    }

    /**
     * @return $this
     */
    public function disableTruncate()
    {
        $this->truncate = false;

        return $this;
    }

    /**
     * @return DoctrineWriter
     */
    public function prepare()
    {
        if (true === $this->truncate) {
            $this->truncateTable();
        }

        return $this;
    }

    /**
     * @param $className
     * @param  array      $item
     * @return mixed
     * @throws \Exception
     */
    protected function getNewInstance($className, array $item)
    {
        if (class_exists($className) === false) {
            throw new \Exception('Unable to create new instance of ' . $className);
        }

        return new $className;
    }

    /**
     * @param $entity
     * @param $value
     * @param $setter
     */
    protected function setValue($entity, $value, $setter)
    {
        if (method_exists($entity, $setter)) {
            $entity->$setter($value);
        }
    }

    /**
     * Re-enable Doctrine logging
     *
     * @return DoctrineWriter
     */
    public function finish()
    {
        $this->objectManager->flush();
        $this->objectManager->clear();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function writeItem(array $item, array $originalItem = array())
    {
        $this->counter++;
        $entity = null;

        // If the table was not truncated to begin with, find current entities
        // first
        if (false === $this->truncate) {
            if ($this->index) {
                $entity = $this->objectRepository->findOneBy(array(
                    $this->index => $item[$this->index]
                ));
            } else {
                $entity = $this->objectRepository->find(current($item));
            }
        }

        if (!$entity) {
            $className = $this->classMetadata->getName();
            $entity = $this->getNewInstance($className, $item);
        }

        $fieldNames = array_merge($this->classMetadata->getFieldNames(), $this->classMetadata->getAssociationNames());
        foreach ($fieldNames as $fieldName) {

            $value = null;
            if (isset($item[$fieldName])) {
                $value = $item[$fieldName];
            } elseif (method_exists($item, 'get' . ucfirst($fieldName))) {
                $value = $item->{'get' . ucfirst($fieldName)};
            }

            if (null === $value) {
                continue;
            }

            if (!($value instanceof \DateTime)
                || $value != $this->classMetadata->getFieldValue($entity, $fieldName)
            ) {
                $setter = 'set' . ucfirst($fieldName);
                $this->setValue($entity, $value, $setter);
            }
        }

        $entity->setOriginalData(json_encode($originalItem, true), 'application/json');

        $this->objectManager->persist($entity);

        if (($this->counter % $this->batchSize) == 0) {
            $this->objectManager->flush();
            $this->objectManager->clear();
        }
    }

    /**
     * Truncate the database table for this writer
     *
     */
    protected function truncateTable()
    {
        $repository = $this->objectRepository;
        foreach ($repository->findAll() as $object) {
            $this->objectManager->remove($object);
        }
        $this->objectManager->flush();
        $this->objectManager->clear();
    }
}
