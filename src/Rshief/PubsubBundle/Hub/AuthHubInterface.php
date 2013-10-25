<?php

namespace Rshief\PubsubBundle\Hub;

interface AuthHubInterface extends GuzzleHubPluginInterface
{
    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getPassword();
}
