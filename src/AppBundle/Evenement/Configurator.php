<?php

namespace AppBundle\Evenement;

use Evenement\EventEmitterInterface;

class Configurator
{
    /**
     * @var array
     */
    private $plugins;

    public function __construct(array $plugins = array())
    {
        $this->plugins = $plugins;
    }

    public function configure(EventEmitterInterface $emitter)
    {
        /** @var PluginInterface $plugin */
        foreach ($this->plugins as $plugin) {
            $plugin->attachEvents($emitter);
        }
    }
}
