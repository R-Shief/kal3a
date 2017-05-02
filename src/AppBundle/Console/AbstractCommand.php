<?php

namespace AppBundle\Console;

use AppBundle\Entity\StreamParameters;
use AppBundle\MergeStreamParameters;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class AbstractCommand extends Command
{
    use LoggerAwareTrait;
    use ContainerAwareTrait;

    const CHILD_PROC_TIMER = 1e-3;

    /**
     * @var array
     */
    protected $params;

    protected function configure()
    {
        $this->addOption('stream', 's', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'stream id', ['enabled']);
        parent::configure();
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $client = $this->container->get('nab3a.guzzle.client.params');
        $serializer = $this->container->get('serializer');
        $merger = new MergeStreamParameters();
        $params = new StreamParameters();
        foreach ((array) $input->getOption('stream') as $stream) {
            if (ctype_digit($stream)) {
                $response = $client->get('stream/'.$stream);
                $streamParameter = $serializer->deserialize($response->getBody(), StreamParameters::class, 'json');
                $params = $merger->merge([$streamParameter, $params]);
            } elseif ($stream === 'enabled') {
                $response = $client->get('stream', ['query' => ['enabled' => 1]]);
                $streamParameter = $serializer->deserialize($response->getBody(), StreamParameters::class .'[]', 'json');
                $params = $merger->merge($streamParameter);
            }
        }

        $this->params = [
          'type' => 'filter',
          'parameters' => $serializer->normalize($params, 'json', [
            'groups' => ['api_request'],
          ]),
        ];
    }
}
