<?php

namespace AppBundle\Evenement;

use Evenement\EventEmitterInterface;

interface PluginInterface
{
    /**
     * @param EventEmitterInterface $emitter
     */
    public function attachEvents(EventEmitterInterface $emitter);
}
