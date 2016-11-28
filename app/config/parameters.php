<?php

namespace App {
    function app_dns_srv_parameter($hostname) {
        $data = dns_get_record($hostname);
        if (empty($data)) {
            throw new \RuntimeException($hostname .' could not be found');
        }
        return $data[0]['target'];
    }

    foreach (['elasticsearch_host', 'database_host', 'rabbitmq_host', 'couchdb_host'] as $name) {
        try {
            $value = app_dns_srv_parameter($container->getParameter($name));
            $container->setParameter($name, $value);
        } catch (\RuntimeException $e) {

        }
    }
}
