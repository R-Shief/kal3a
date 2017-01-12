<?php

namespace AppBundle\Stream;

use Evenement\EventEmitterInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use AppBundle\Evenement;
use AppBundle\EventLoop;
use Psr\Log\LoggerAwareTrait;
use React\EEP\Composite;
use React\EEP\Stats;
use React\EEP\Window;
use React\EventLoop\LoopInterface;

/**
 * Class Eep.
 *
 * @property LoggerInterface logger
 */
class Eep implements Evenement\PluginInterface, EventLoop\PluginInterface, LoggerAwareInterface
{
    const MINUTE_MS = 60e3;
    const SECOND_MS = 1e3;
    const HOUR_MS = 3600e3;

    /**
     * @var Window\Periodic
     */
    private $statusCounter;

    /**
     * @var Window\Periodic
     */
    private $statusAverager;

    /**
     * @var Window\Periodic
     */
    private $idleTime;

    use LoggerAwareTrait;

    public function __construct(Window\Periodic $statusCounter, Window\Periodic $statusAverager, Window\Periodic $idleTime)
    {
        $this->statusCounter = $statusCounter;
        $this->statusAverager = $statusAverager;
        $this->idleTime = $idleTime;
    }

    /**
     * @param EventEmitterInterface $emitter
     */
    public function attachEvents(EventEmitterInterface $emitter)
    {
        $emitter->on('tweet', [$this, 'tweetTimer']);
        $emitter->on('tweet', [$this, 'tweetCounter']);
    }

    /**
     * @param LoopInterface $loop
     */
    public function attach(LoopInterface $loop)
    {
        $loop->addPeriodicTimer(.5, [$this, 'ticker']);
    }

    public function tweetTimer()
    {
        static $time;

        if ($time) {
            $ut = microtime(true);
            $v = abs($ut - $time);
            $this->idleTime->enqueue($v);
            $time = $ut;
        } else {
            $time = microtime(true);
        }
    }

    /**
     * @param $data
     */
    public function tweetCounter($data)
    {
        $this->statusCounter->enqueue($data);
        $this->statusAverager->enqueue($data);
    }

    public function ticker()
    {
        $this->statusCounter->tick();
        $this->statusAverager->tick();
        $this->idleTime->tick();
    }

    /**
     * @return Window\Periodic
     */
    public function makeIdleTimeTracker()
    {
        $emitter = new Window\Periodic(new Composite([
          new Stats\Max(), new Stats\Mean(), new Stats\Min(), new Stats\Sum(),
        ]), self::MINUTE_MS);
        $emitter->on('emit', function ($emit) {
            $context = array_combine(['max', 'mean', 'min', 'total'], array_map(function ($num) {
                return round($num, 4);
            }, $emit));
            $this->logger->info('idleTime', $context);
        });

        return $emitter;
    }

    /**
     * @return Window\Periodic
     */
    public function makeStatusCounter()
    {
        $emitter = new Window\Periodic(new Stats\Count(), self::MINUTE_MS);
        $emitter->on('emit', function ($emit) {
            $this->logger->info(sprintf('statusCount %s in %s seconds', $emit, self::MINUTE_MS / 1000));
        });

        return $emitter;
    }

    /**
     * @return Window\Periodic
     */
    public function makeStatusAverager()
    {
        $avg_tw = new Window\Tumbling(new Stats\Mean(), self::MINUTE_MS / self::SECOND_MS);
        $avg_tw->on('emit', function ($emit) {
            $this->logger->info(sprintf('statusAverage %s in %s seconds', $emit, self::SECOND_MS / 1000));
        });

        $emitter = new Window\Periodic(new Stats\Count(), self::SECOND_MS);
        $emitter->on('emit', function ($emit) use ($avg_tw) {
            $avg_tw->enqueue($emit);
        });

        return $emitter;
    }
}
