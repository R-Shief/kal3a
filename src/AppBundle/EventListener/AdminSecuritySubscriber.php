<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Group;
use AppBundle\Entity\Query;
use AppBundle\Entity\StreamParameters;
use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminSecuritySubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onPostInitialize(Event $event)
    {
        $entity = $event['entity'];
        $request = $event['request'];
        $action = $request->query->get('action', 'list');

        if (($entity['class'] === User::class || $entity['class'] === Group::class) && !$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Only administrators can manage users and groups.');
        }

        if ($entity['class'] === StreamParameters::class || $entity['class'] === Query::class) {
            if ($action === 'edit' || $action === 'show' || $action === 'delete' || $action === 'export') {
                if ($action === 'show' || $action === 'export') {
                    $action = 'view';
                }
                $easyadmin = $request->attributes->get('easyadmin');
                $item = $easyadmin['item'];
                if (!$this->authorizationChecker->isGranted(strtoupper($action), $item)) {
                    throw new AccessDeniedException('That is not your entity');
                }
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
          'easy_admin.post_initialize' => array('onPostInitialize'),
        );
    }
}
