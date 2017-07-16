<?php

namespace AppBundle\Stream;

use React\ChildProcess\Process;
use AppBundle\Console\AbstractCommand;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class PipeCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();
        $this
          ->setName('pipe')
          ->setDescription('Connect to a streaming API endpoint and collect data')
          ->addOption('watch', null, InputOption::VALUE_NONE, 'watch for stream configuration changes and reconnect according to API rules')
          ->addOption('out', null, InputOption::VALUE_OPTIONAL, 'output', STDOUT)
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int null or 0 if everything went fine, or an error code
     * @throws InvalidArgumentException
     * @throws \RuntimeException
     * @throws ServiceNotFoundException
     * @throws ServiceCircularReferenceException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = $this->container->get('nab3a.event_loop');
        $pcntl = $this->container->get('nab3a.pcntl');

        // @todo

        // we need a timer that keeps track of the time the current connection
        // was started, because we must avoid connection churning.

        // filter parameters will change, we want to signal to the streaming
        // client that there it should reconnect, but if we don't accommodate
        // the fact that multiple changes could happen in a quick sequence, we'd
        // probably get blocked from the streaming API endpoints for too many
        // connection attempts.

        // When this app receives those errors, it manages them correctly,
        // but it still stupidly allows these situations to arise.
        // $timer = $watcher->watch($resource);

        $stringOption = implode(' ', array_map(function ($option) {
            return '--stream '. $option;
        }, $input->getOption('stream')));

        $process = $this->container
          ->get('nab3a.process.child_process')
          ->makeChildProcess('stream:read:twitter -vvv '.$stringOption);

        $this->attachListeners($process);

        $process->stderr->pipe($this->container->get('nab3a.console.logger_helper'));
        $process->stdout->pipe($this->container->get('nab3a.twitter.message_emitter'));
        $process->on('exit', function ($exitCode, $termSignal) use ($loop, $process) {
            $this->container->get('logger')->info(sprintf('child process pid %d exited with code %d signal %s', $process->getPid(), $exitCode, $termSignal));
            $loop->stop();
        });

        $pcntl->on(SIGTERM, function () use ($loop, $process) {
            $this->container->get('logger')->info(sprintf('process pid %d exited with code %d signal %s', posix_getpid(), 0, SIGTERM));
            if ($process->isRunning()) {
                $process->terminate();
            }
            $loop->stop();
        });

        $loop->run();

        return 1;
    }

    /**
     * @param Process $process
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     */
    private function attachListeners(Process $process)
    {
        $dispatcher = $this->container->get('event_dispatcher');
        $listener = function () use ($process) {
            if ($process->isRunning()) {
                $process->terminate();
                usleep(self::CHILD_PROC_TIMER * 1e6);
            }
            $this->container->get('nab3a.event_loop')->stop();
        };
        $dispatcher->addListener(ConsoleEvents::EXCEPTION, $listener);
        $dispatcher->addListener(ConsoleEvents::TERMINATE, $listener);
        register_shutdown_function($listener);
    }
}
