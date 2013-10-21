<?php

namespace Rshief\MigrationBundle\Writer;

use Ddeboer\DataImport\Writer\AbstractWriter;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

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
     * @var EntityManager
     */
    protected $objectManager;

    /**
     * Fully qualified entity name
     *
     * @var string
     */
    protected $entityName;

    /**
     * Doctrine entity repository
     *
     * @var EntityRepository
     */
    protected $entityRepository;

    /**
     * @var ClassMetadata
     */
    protected $entityMetadata;

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
     *
     * @param EntityManager $objectManager
     * @param string        $entityName
     * @param string        $index         Index to find current entities by
     */
    public function __construct(ObjectManager $objectManager, $entityName, $index = null)
    {
        $this->objectManager = $objectManager;
        $this->entityName = $entityName;
        $this->entityRepository = $objectManager->getRepository($entityName);
        $this->entityMetadata = $objectManager->getClassMetadata($entityName);
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
     * @return DoctrineWriter
     */
    public function prepare()
    {
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
        if ($this->index) {
            $entity = $this->entityRepository->findOneBy(array(
                $this->index => $item[$this->index]
            ));
        } else {
            $entity = $this->entityRepository->find(current($item));
        }

        if (!$entity) {
            $className = $this->entityMetadata->getName();
            $entity = $this->getNewInstance($className, $item);
        }

        foreach ($this->entityMetadata->getFieldNames() as $fieldName) {

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
                || $value != $this->entityMetadata->getFieldValue(
                    $entity, $fieldName
                ))
            {
                $setter = 'set' . ucfirst($fieldName);
                $this->setValue($entity, $value, $setter);
            }
        }

        $this->objectManager->persist($entity);

        if (($this->counter % $this->batchSize) == 0) {
            $this->objectManager->flush();
            $this->objectManager->clear();
        }
    }
}
