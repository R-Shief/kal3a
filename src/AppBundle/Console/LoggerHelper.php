<?php

namespace AppBundle\Console;

use Clue\JsonStream\StreamingJsonParser;
use Psr\Log\LoggerInterface;
use React\Stream\WritableStream;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoggerHelper extends WritableStream
{
    use ContainerAwareTrait;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var StreamingJsonParser
     */
    private $parser;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        $this->parser = new StreamingJsonParser();
    }

    public function write($chunk)
    {
        try {
            foreach ($this->parser->push($chunk) as $data) {
                $id = 'logger';
                if (isset($data['channel']) && $data['channel'] !== 'app') {
                    $id = 'monolog.logger.'.$data['channel'];
                }
                /** @var LoggerInterface $logger */
                $logger = $this->container->get($id);
                $logger->log($data['level'], $data['message'], $data['context']);
            }
        } catch (\UnexpectedValueException $e) {
            $this->output->write($chunk);
        }
    }
}
