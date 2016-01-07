<?php

namespace Rshief\Bundle\Kal3aBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class DefaultResponseHeaderListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->setVary(array('Accept-Encoding', 'Origin'));
    }
}
