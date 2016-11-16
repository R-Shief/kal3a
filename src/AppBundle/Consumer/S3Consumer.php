<?php

namespace AppBundle\Consumer;

use Aws\Command;
use Aws\CommandInterface;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3ClientInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerAwareInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use Psr\Log\LoggerAwareTrait;

class S3Consumer implements ConsumerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var S3ClientInterface
     */
    private $client;

    /**
     * S3Consumer constructor.
     *
     * @param S3ClientInterface $client
     *
     * @todo inject parameter for s3 bucket name
     */
    public function __construct(S3ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        $data = \GuzzleHttp\json_decode($msg->getBody(), true);

        try {
            $tweet_path = 'twitter.com/';
            $created_at = \DateTime::createFromFormat('D M j H:i:s P Y', $data['created_at']);
            $tweet_path .= $created_at->format('Y').'/'.$created_at->format('m').'/'.$created_at->format('d').'/';
            $tweet_path .= $data['user']['screen_name'].'/'.$data['id_str'];

            $result = $this->client->upload('kal3a', $tweet_path, $msg->getBody(), 'private', [
              'before_upload' => function (Command $command) {
                  $command->getHandlerList()->appendBuild(function (callable $handler) {
                      return function (CommandInterface $command, RequestInterface $request = null) use ($handler) {
                          if ($request) {
                              $request = $request->withHeader('Content-Type', 'application/json');
                          }

                          return $handler($command, $request);
                      };
                  });

                  return $command;
              },
            ]);

            return ConsumerInterface::MSG_ACK;
        } catch (S3Exception $e) {
            return ConsumerInterface::MSG_REJECT_REQUEUE;
        }
    }
}
