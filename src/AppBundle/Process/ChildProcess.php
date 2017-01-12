<?php

namespace AppBundle\Process;

use React\ChildProcess\Process;
use React\EventLoop\LoopInterface;
use Symfony\Component\Process\ProcessUtils;

class ChildProcess
{
    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * ChildProcess constructor.
     *
     * @param LoopInterface $loop
     */
    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    /**
     * @param string $cmd Command line to run
     * @param string $cwd Current working directory or null to inherit
     * @param array $env Environment variables or null to inherit
     * @param array $options Options for proc_open()
     *
     * @return Process
     * @throws \RuntimeException
     */
    public function makeChildProcess($cmd, $cwd = null, array $env = null, array $options = array())
    {
        $cmd = 'exec php '.ProcessUtils::escapeArgument($_SERVER['argv'][0]).' --child '.$cmd;

        $process = new Process($cmd, $cwd, $env, $options);
        $process->start($this->loop);

        return $process;
    }
}
