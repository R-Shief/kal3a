<?php

namespace AppBundle\Stream;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use React\EEP\Composite;
use React\EEP\Stats;
use React\EEP\Window;

class PeriodicFactory implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const MINUTE_MS = 60e3;
    const SECOND_MS = 1e3;
    const HOUR_MS = 3600e3;

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
