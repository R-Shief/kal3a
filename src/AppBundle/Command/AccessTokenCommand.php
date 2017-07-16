<?php

namespace AppBundle\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use React\EventLoop\LoopInterface;
use React\Http;
use React\Socket;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

class AccessTokenCommand extends ContainerAwareCommand
{
    /**
     * @var array
     */
    private $requestToken = [];

    /**
     * @var array
     */
    private $accessToken = [];

    protected function configure()
    {
        parent::configure();
        $this->setName('twitter:access-token');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws InvalidArgumentException
     * @throws ServiceNotFoundException
     * @throws ServiceCircularReferenceException
     * @throws Socket\ConnectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = random_int(pow(2, 15) + pow(2, 14), pow(2, 16) - 1);

        $handler = $this->getContainer()->get('nab3a.guzzle.client.handler');
        $middleware = new Oauth1([
          'consumer_key' => $this->getContainer()->getParameter('nab3a.twitter.consumer_key'),
          'consumer_secret' => $this->getContainer()->getParameter('nab3a.twitter.consumer_secret'),
          'token' => null,
          'token_secret' => null,
        ]);
        $handler->push($middleware);

        $client = new Client(['handler' => $handler]);

        try {
            $response = $client->request('post', 'https://api.twitter.com/oauth/request_token', [
              'auth' => 'oauth',
              'form_params' => [
                'oauth_callback' => 'http://localhost:'.$port,
              ],
            ]);
            parse_str($response->getBody(), $this->requestToken);
        } catch (RequestException $e) {
            dump(Psr7\str($e->getResponse()));
        }

        $uri = Psr7\uri_for('https://api.twitter.com/oauth/authorize')->withQuery(Psr7\build_query(['oauth_token' => $this->requestToken['oauth_token']]));
        $url = (string) $uri;

        $cmd = self::openBrowser($url);
        if ($cmd) {
            $proc = new Process($cmd.' '.$url);
            $proc->run();
        } else {
            $output->writeln('no suitable browser opening command found, open yourself: '.$url);
        }

        $loop = $this->getContainer()->get(LoopInterface::class);

        $socket = new Socket\Server($loop);
        $socket->listen($port);

        $http = new Http\Server($socket);
        $http->once('request', [$this, 'serverListener']);

        $loop->run();

        $output->writeln(Yaml::dump($this->accessToken));
    }

    /**
     * @param Http\Request  $request
     * @param Http\Response $response
     */
    public function serverListener(Http\Request $request, Http\Response $response)
    {
        $query = $request->getQuery();
        if (isset($query['oauth_token']) && $this->requestToken['oauth_token'] !== $query['oauth_token']) {
            // Abort! Something is wrong.
        }

        $handler = $this->getContainer()->get('nab3a.guzzle.client.handler');
        $middleware = new Oauth1([
          'consumer_key' => $this->getContainer()->getParameter('nab3a.twitter.consumer_key'),
          'consumer_secret' => $this->getContainer()->getParameter('nab3a.twitter.consumer_secret'),
          'token' => $this->requestToken['oauth_token'],
          'token_secret' => $this->requestToken['oauth_token_secret'],
        ]);
        $handler->push($middleware);

        $client = new Client(['handler' => $handler]);

        $res = $client->request('post', 'https://api.twitter.com/oauth/access_token', [
          'auth' => 'oauth',
          'form_params' => ['oauth_verifier' => $query['oauth_verifier']],
        ]);
        parse_str($res->getBody(), $this->accessToken);

        $response->writeHead(200, array('Content-Type' => 'text/html'));

        $response->write('<!DOCTYPE "html">');
        $response->write('<html>');
        $response->write('<head>');
        $response->write('<title>Successfully Authenticated</title>');
        $response->write('</head>');
        $response->write('<body>');
        $response->write('You\'ve been authenticated with Twitter! You may close this page.');
        $response->write('<script>open(location, \'_self\').close();</script>');
        $response->write('</body>');
        $response->write('</html>');
        $response->end();
        $response->on('close', function () {
            $this->getContainer()->get('nab3a.event_loop')->stop();
        });
    }

    /**
     * @param $url
     *
     * @return string
     */
    private static function openBrowser($url)
    {
        $finder = new ExecutableFinder();
        if (defined('PHP_WINDOWS_VERSION_BUILD')) {
            return passthru('start "web" explorer "'.$url.'"');
        }
        $cmd = $finder->find('xdg-open') ?: $finder->find('open');

        return $cmd;
    }
}
