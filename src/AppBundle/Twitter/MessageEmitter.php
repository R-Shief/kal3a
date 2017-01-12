<?php

namespace AppBundle\Twitter;

use Clue\JsonStream\StreamingJsonParser;
use React\Stream\WritableStream;

/**
 * Class MessageEmitter.
 *
 * This writable stream emits different types of messages from Twitter
 * Streaming API.
 */
class MessageEmitter extends WritableStream
{
    /**
     * @var TypeGuesser
     */
    private $guesser;

    /**
     * @var StreamingJsonParser
     */
    private $parser;

    public function __construct(TypeGuesser $guesser)
    {
        $this->guesser = $guesser;
        $this->parser = new StreamingJsonParser();
    }

    /**
     * @param $data
     */
    public function write($data)
    {
        // Blank lines are a keep-alive signal.
        if ($data === "\r\n") {
            $this->emit('keep-alive');

            return;
        }

        foreach ($this->parser->push($data) as $object) {
            $event = $this->guesser->getEventName($object);
            $this->emit($event, [$object]);
        }
    }
}
