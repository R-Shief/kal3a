<?php

namespace Bangpound\PhirehoseBundle\Stream;

use Bangpound\PhirehoseBundle\Event\StreamMessageEvent;
use Bangpound\PhirehoseBundle\PhirehoseEvents;
use Doctrine\Common\Persistence\ObjectManager;
use OauthPhirehose as OauthPhirehose;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BasicStream extends OauthPhirehose implements LoggerAwareInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var int
     */
    protected $lastMemoryUsage;

    /**
     * @param ObjectManager $em
     */
    public function setEntityManager(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function enqueueStatus($status)
    {
        $body = json_decode($status, true, 512, JSON_BIGINT_AS_STRING);
        $eventName = count($body) > 1 ? PhirehoseEvents::TWEET : 'phirehose.'.key($body);
        $event = new StreamMessageEvent(trim($status));
        $this->dispatcher->dispatch($eventName, $event);
    }

    /**
     * {@inheritdoc}
     */
    protected function log($message, $level = 'notice')
    {
        $this->logger->log($level, trim($message));
    }

    /**
     * {@inheritdoc}
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
