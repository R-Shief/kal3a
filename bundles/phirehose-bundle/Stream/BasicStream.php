<?php

namespace Bangpound\PhirehoseBundle\Stream;

use Bangpound\PhirehoseBundle\Event\StreamMessageEvent;
use Bangpound\PhirehoseBundle\PhirehoseEvents;
use Doctrine\Common\Persistence\ObjectManager;
use OauthPhirehose as OauthPhirehose;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BasicStream extends OauthPhirehose
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var ObjectManager
     */
    protected $em;
    protected $lastMemoryUsage;

    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    public function setEntityManager(ObjectManager $em)
    {
        $this->em = $em;

        return $this;
    }

    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function enqueueStatus($status)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            $body = json_decode($status, true, 512, JSON_BIGINT_AS_STRING);
        } else {
            $body = json_decode($status, true, 512);
        }

        $eventName = count($body) > 1 ? PhirehoseEvents::TWEET : 'phirehose.'.key($body);
        $event = new StreamMessageEvent(trim($status));
        $this->dispatcher->dispatch($eventName, $event);
    }

    /**
     * {@inheritdoc}
     */
    public function heartbeat()
    {
        $memory_usage = memory_get_usage();
        $message = 'Memory usage: '.$this->formatMemory($memory_usage).', ';
        if ($this->lastMemoryUsage) {
            if ($memory_usage > $this->lastMemoryUsage) {
                $message .= 'Δ <info>'.$this->formatMemory($memory_usage - $this->lastMemoryUsage).'</info>, ';
            } else {
                $message .= 'Δ '.$this->formatMemory($memory_usage - $this->lastMemoryUsage).', ';
            }
        }

        $message .= 'Peak: '.$this->formatMemory(memory_get_peak_usage(true));
        $this->log($message);
        $this->lastMemoryUsage = $memory_usage;

        parent::heartbeat();
    }

    private function formatMemory($memory)
    {
        $memory = (int) $memory;
        if (abs($memory) < 1024) {
            return $memory.' B';
        } elseif (abs($memory) < 1048576) {
            return round($memory / 1024, 2).' KB';
        } else {
            return round($memory / 1048576, 2).' MB';
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function log($message, $level = 'notice')
    {
        if ($level == 'notice') {
            $this->output->writeln(sprintf('%s', trim($message)));
        } else {
            $this->output->writeln(sprintf('<%s>%s</%s>', $level, trim($message), $level));
        }
    }
}
