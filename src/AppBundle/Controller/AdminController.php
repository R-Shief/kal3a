<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;

/**
 * Class AdminController.
 *
 * @Sensio\Route("/admin")
 */
class AdminController extends BaseController
{
    /**
     * @param string $entityClass
     * @param string $sortDirection
     * @param null $sortField
     * @param null $dqlFilter
     * @return \Doctrine\ORM\Query
     */
    protected function createStreamParametersListQueryBuilder(
      $entityClass,
      $sortDirection,
      $sortField = null,
      $dqlFilter = null
    ) {
        $query = parent::createListQueryBuilder(
          $entityClass,
          $sortDirection,
          $sortField,
          $dqlFilter
        );
        return $this->get('orm_acl_security.filter.acl')->apply($query);
    }

    /**
     * @param string $entityClass
     * @param string $searchQuery
     * @param array $searchableFields
     * @param null $sortField
     * @param null $sortDirection
     * @param null $dqlFilter
     * @return \Doctrine\ORM\Query
     */
    protected function createStreamParametersSearchQueryBuilder(
      $entityClass,
      $searchQuery,
      array $searchableFields,
      $sortField = null,
      $sortDirection = null,
      $dqlFilter = null
    ) {
        $query = parent::createSearchQueryBuilder(
          $entityClass,
          $searchQuery,
          $searchableFields,
          $sortField,
          $sortDirection,
          $dqlFilter
        );
        return $this->get('orm_acl_security.filter.acl')->apply($query);
    }

    /**
     * @param string $entityClass
     * @param string $sortDirection
     * @param null $sortField
     * @param null $dqlFilter
     * @return \Doctrine\ORM\Query
     */
    protected function createQueryListQueryBuilder(
      $entityClass,
      $sortDirection,
      $sortField = null,
      $dqlFilter = null
    ) {
        $query = parent::createListQueryBuilder(
          $entityClass,
          $sortDirection,
          $sortField,
          $dqlFilter
        );
        return $this->get('orm_acl_security.filter.acl')->apply($query);
    }

    /**
     * @param string $entityClass
     * @param string $searchQuery
     * @param array $searchableFields
     * @param null $sortField
     * @param null $sortDirection
     * @param null $dqlFilter
     * @return \Doctrine\ORM\Query
     */
    protected function createQuerySearchQueryBuilder(
      $entityClass,
      $searchQuery,
      array $searchableFields,
      $sortField = null,
      $sortDirection = null,
      $dqlFilter = null
    ) {
        $query = parent::createSearchQueryBuilder(
          $entityClass,
          $searchQuery,
          $searchableFields,
          $sortField,
          $sortDirection,
          $dqlFilter
        );
        return $this->get('orm_acl_security.filter.acl')->apply($query);
    }

    /**
     * @return \FOS\UserBundle\Model\UserInterface|mixed
     */
    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    protected function exportAction()
    {
        $id = $this->request->query->get('id');

        return $this->redirectToRoute('app_export_index', ['query' => $id]);
    }

    public function createNewGroupEntity()
    {
        return new Group('');
    }
}
