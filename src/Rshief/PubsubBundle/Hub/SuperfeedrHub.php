<?php

namespace Rshief\PubsubBundle\Hub;

use Guzzle\Plugin\CurlAuth\CurlAuthPlugin;
use Sputnik\Bundle\PubsubBundle\Hub\Hub as BaseHub;

class SuperfeedrHub extends BaseHub implements AuthHubInterface
{
    private $username;
    private $password;

    /**
     * @param string $name
     * @param string $url
     * @param array  $params
     * @param string $username;
     * @param string $password;
     */
    public function __construct($name, $url, array $params = array(), $username = NULL, $password = NULL)
    {
        $this->username = $username;
        $this->password = $password;
        parent::__construct($name, $url, $params);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSubscribers() {
        return [ new CurlAuthPlugin($this->username, $this->password) ];
    }
}
