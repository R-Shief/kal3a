<?php

namespace Rshief\MigrationBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use JMS\JobQueueBundle\Entity\Job;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EnqueueCommand extends DoctrineCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('migrate:enqueue')
            ->addArgument('type', InputArgument::REQUIRED, 'The mapping type to be converted.')
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'The size of each batch.', 100)
            ->addOption('offset', 'o', InputOption::VALUE_REQUIRED, 'The primary key of the record to start with', 0);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getEntityManager('default');
        $repository = $em->getRepository($input->getArgument('type'));
        $entities = $repository->findBy([], ['postid' => 'ASC'], $input->getOption('limit'), $input->getOption('offset'));
        foreach ($entities as $entity) {
            $job = new Job('migrate:to-couchdb');
            $job->addRelatedEntity($entity);
            $em->persist($job);
        }
        if (count($entities) == $input->getOption('limit')) {
            $job = new Job('migrate:enqueue', [
                '--limit', $input->getOption('limit'),
                '--offset', $input->getOption('offset') + $input->getOption('limit'),
                $input->getArgument('type'),
            ]);
            $em->persist($job);
        }
        $em->flush();
    }
}
