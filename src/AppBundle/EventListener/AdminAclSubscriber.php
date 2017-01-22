<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Query;
use AppBundle\Entity\StreamParameters;
use AppBundle\Security\AclManager;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Role\Role;

class AdminAclSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AclManager
     */
    private $aclManager;

    public function __construct(TokenStorageInterface $tokenStorage, AclManager $aclManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->aclManager = $aclManager;
    }

    public function onPostPersist(Event $event)
    {
        if ($event['entity'] instanceof StreamParameters || $event['entity'] instanceof Query) {
            $this->aclManager->makeOwner($event['entity'], $this->tokenStorage->getToken()->getUser());
            $this->aclManager->makeVisible($event['entity'], new Role('ROLE_USER'));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
          'easy_admin.post_persist' => array('onPostPersist'),
        ];
    }
}
