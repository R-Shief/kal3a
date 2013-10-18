<?php

namespace Rshief\MigrationBundle\Controller;

use JMS\JobQueueBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $job = new Job('container:debug');
        $em->persist($job);
        $em->flush($job);

        $job = new Job('a');
        $date = new \DateTime();
        $date->add(new \DateInterval('PT30M'));
        $job->setExecuteAfter($date);
        $em->persist($job);
        $em->flush();

        return $this->render('RshiefMigrationBundle:Default:index.html.twig', array('name' => $name));
    }
}
