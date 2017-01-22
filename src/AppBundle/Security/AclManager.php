<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Exception\AclAlreadyExistsException;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;
use Symfony\Component\Security\Acl\Exception\InvalidDomainObjectException;
use Symfony\Component\Security\Acl\Model\MutableAclProviderInterface;
use Symfony\Component\Security\Acl\Model\ObjectIdentityInterface;
use Symfony\Component\Security\Acl\Model\SecurityIdentityInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AclManager
{
    /**
     * @var MutableAclProviderInterface
     */
    private $aclProvider;

    /**
     * AclManager constructor.
     *
     * @param MutableAclProviderInterface $aclProvider
     */
    public function __construct(MutableAclProviderInterface $aclProvider)
    {
        $this->aclProvider = $aclProvider;
    }

    /**
     * @param $entity
     * @param UserInterface $user
     *
     * @throws AclAlreadyExistsException
     * @throws InvalidDomainObjectException
     */
    public function makeOwner($entity, UserInterface $user)
    {
        // creating the ACL
        $objectIdentity = ObjectIdentity::fromDomainObject($entity);
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        $this->addOrCreateAcl($objectIdentity, $securityIdentity, MaskBuilder::MASK_OWNER);
    }

    public function makeVisible($entity, RoleInterface $role)
    {
        $objectIdentity = ObjectIdentity::fromDomainObject($entity);
        $securityIdentity = new RoleSecurityIdentity($role);
        $this->addOrCreateAcl($objectIdentity, $securityIdentity, MaskBuilder::MASK_VIEW);
    }

    /**
     * @param ObjectIdentityInterface $objectIdentity
     * @param SecurityIdentityInterface $securityIdentity
     * @param $mask
     *
     * @internal param $entity
     * @internal param $user
     */
    public function addOrCreateAcl(ObjectIdentityInterface $objectIdentity, SecurityIdentityInterface $securityIdentity, $mask)
    {
        try {
            $acl = $this->aclProvider->findAcl($objectIdentity);
        } catch (AclNotFoundException $e) {
            $acl = $this->aclProvider->createAcl($objectIdentity);
        }
        $acl->insertObjectAce($securityIdentity, $mask);
        $this->aclProvider->updateAcl($acl);
    }
}
