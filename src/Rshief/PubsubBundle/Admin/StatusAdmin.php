<?php

namespace Rshief\PubsubBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;

class StatusAdmin extends Admin
{
    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_order' => 'DESC', // sort direction
        '_sort_by' => 'timestamp' // field name
    );

    public function setParentAssociationMapping($associationMapping)
    {
        $this->parentAssociationMapping = $associationMapping;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('url', 'url', array('required' => true))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('httpCode')
            ->add('timestamp')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('httpCode')
            ->addIdentifier('http', null, array('route' => array('name' => 'show')))
            ->add('timestamp')
            ->add('period')
        ;
    }

    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('httpCode')
            ->add('http')
            ->add('headers', 'text', array('label' => 'Headers'))
            ->add('timestamp')
            ->add('nextFetch')
            ->add('lastFetch')
            ->add('lastParse')
            ->add('lastMaintenanceAt')
            ->add('entriesCountSinceLastMaintenance')
            ->add('period')
        ;
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('edit');
        $collection->remove('create');
    }
}
