<?php
namespace Rshief\MigrationBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\HTTP\Client;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ToCouchDBCommand
 * @package Rshief\MigrationBundle\Command
 */
class ToCouchDBCommand extends DoctrineCommand
{
    public function setClient(CouchDBClient $client)
    {
        $this->client = $client;
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('migrate:to-couchdb')
//            ->addArgument('type', InputArgument::REQUIRED, 'The mapping type to be converted.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $c = $this->getContainer();

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $c->get('doctrine')->getManagerForClass('JMSJobQueueBundle:Job');

        /** @var \JMS\JobQueueBundle\Entity\Repository\JobRepository $repo */
        $repo = $em->getRepository('JMSJobQueueBundle:Job');

        /** @var \Doctrine\CouchDB\CouchDBClient $client */
        $client = $this->client;

        /** @var \JMS\JobQueueBundle\Entity\Job $job */
        $job = $repo->findOneBy(['id' => $input->getOption('jms-job-id')]);

        /** @var \Rshief\MigrationBundle\Entity\VBulletinPost $entity */
        $entity = $job->findRelatedEntity('Rshief\\MigrationBundle\\Entity\\VBulletinPost');

        $client->putDocument((array) $entity, (string) $entity->getPostid());
    }
}
