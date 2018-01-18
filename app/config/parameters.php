<?php

declare(strict_types = 1);

use DL\ConsulPhpEnvVar\Builder\ConsulEnvManagerBuilder;

$builder = (new ConsulEnvManagerBuilder())
  ->withOverwriteEvenIfDefined(true);

if (getenv('CONSUL_SERVER')) {
    $builder->withConsulServer(getenv('CONSUL_SERVER'));
}

$manager = $builder->build();

$mappings = [
  'TWITTER_CONSUMER_KEY' => 'twitter/consumer_key',
  'TWITTER_CONSUMER_SECRET' => 'twitter/consumer_secret',
  'TWITTER_ACCESS_TOKEN' => 'twitter/1/access_token',
  'TWITTER_ACCESS_TOKEN_SECRET' => 'twitter/1/access_token_secret',
];

$manager->getEnvVarsFromConsul($mappings);
$manager->exposeEnvironmentIntoContainer($container, $mappings);
