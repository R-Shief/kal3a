<?php

function app_dns_srv_parameter($hostname) {
    $data = dns_get_record($hostname);
    if (empty($data) || !isset($data[0]['target'])) {
        throw new \RuntimeException($hostname .' could not be found');
    }
    return $data[0]['target'];
}
