<?php

namespace AppBundle\EventLoop;

use React\EventLoop\LoopInterface;

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

    public function configure(LoopInterface $loop)
    {
        /** @var PluginInterface $plugin */
        foreach ($this->plugins as $plugin) {
            $plugin->attach($loop);
        }
    }
}
