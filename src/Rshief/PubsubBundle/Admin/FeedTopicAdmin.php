<?php

namespace Rshief\PubsubBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class FeedTopicAdmin extends Admin
{

    protected function configureSideMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit', 'show'))) { return; }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        $menu->addChild('Topic', array('uri' => $admin->generateUrl('show', array('id' => $id))));
        $menu->addChild('Feed', array('uri' => $admin->generateUrl('rshief.pubsub.feed.list', array('id' => $id))));
        $menu->addChild('Statuses', array('uri' => $admin->generateUrl('rshief.pubsub.status.list', array('id' => $id))));
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('topic', 'sonata_type_admin', array('required' => true, 'delete' => false, 'label' => false))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('topic.hubName')
            ->add('topic.topicUrl')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('topic.topicUrl', null, array('route' => array('name' => 'show')))
            ->add('topic.hubName')
            ->add('topic.createdAt')
            ->add('topic.updatedAt')
        ;
    }

    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('topic.topicUrl', null, array('template' => 'RshiefPubsubBundle:CRUD:show_orm_one_to_one.html.twig'))
            ->add('topic.hubName')
            ->add('topic.createdAt')
            ->add('topic.updatedAt')
        ;
    }
}
