<?php

namespace App {

    use Symfony\Component\DependencyInjection\ContainerBuilder;
    use Symfony\Component\Yaml\Yaml;

    function app_dns_srv_parameter($hostname) {
        $data = dns_get_record($hostname);
        if (empty($data)) {
            throw new \RuntimeException($hostname .' could not be found');
        }
        return $data[0]['target'];
    }

    $data = Yaml::parse(file_get_contents(__DIR__.'/parameters.yml'));
    /** @var \Symfony\Component\DependencyInjection\ParameterBag\ParameterBag $params */
    foreach ($data['parameters'] as $k => $v) {
        $value = $v;
        if (is_string($v) && !empty($v) && in_array($k, ['elasticsearch_host', 'database_host', 'rabbitmq_host', 'couchdb_host'])) {
            try {
                $value = app_dns_srv_parameter($v);
            } catch (\RuntimeException $e) {
                $value = $v;
            }
        }
        /** @var ContainerBuilder $container */
        $container->setParameter($k, $value);
    }
}
