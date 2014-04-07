<?php

namespace Bangpound\Bundle\CastleSearchBundle\Block;

use Bangpound\Bundle\CastleSearchBundle\DocumentManager;
use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\View\Query;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TopTagBlockService
 * @package Bangpound\Bundle\CastleSearchBundle\Block
 */
class TopTagBlockService extends DateViewBlockService
{
    /**
     * @var DocumentManager
     */
    protected $manager;

    /**
     * @var CouchDBClient
     */
    protected $client;

    /**
     * @param FormMapper     $form
     * @param BlockInterface $block
     *
     * @return void
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
        $form->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('design_document', 'text', array('required' => true)),
                array('view', 'text', array('required' => false)),
                array('list', 'text', array('required' => false)),
                array('stale', 'checkbox'),
                array('descending', 'checkbox'),
                array('reduce', 'checkbox'),
                array('group', 'checkbox'),
                array('group_level', 'integer'),
            )
        ));
    }

    /**
     * @param  BlockContextInterface                     $blockContext
     * @return \Doctrine\CouchDB\View\AbstractQuery|null
     */
    public function query(BlockContextInterface $blockContext)
    {
        $settings = $blockContext->getSettings();
        $query = $this->client->createViewQuery($settings['design_document'], $settings['view']);

        return $query;
    }

    /**
     * @param ErrorElement   $errorElement
     * @param BlockInterface $block
     *
     * @return void
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        $errorElement
            ->with('settings.design_document')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->end()
            ->with('settings.view')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->end()
            ->with('settings.list')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->end()
            ->with('settings.descending')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->end()
            ->with('settings.reduce')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->end()
            ->with('settings.group')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->end()
            ->with('settings.group_level')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->end();
    }

    /**
     * Define the default options for the block
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        parent::setDefaultSettings($resolver);
        $resolver->replaceDefaults(array(
            'list' => false,
            'template' => 'BangpoundCastleSearchBundle:Block:block_view.html.twig',
        ));
    }

    /**
     * @param  Query                 $query
     * @param  BlockContextInterface $blockContext
     * @return array
     */
    public function results(Query $query, BlockContextInterface $blockContext)
    {
        $results = array();

        foreach ($query->execute() as $result) {
            $results[$result['value']] = $result['key'][3];
        }

        return $results;
    }

    /**
     * @param CouchDBClient $client
     */
    public function setClient(CouchDBClient $client)
    {
        $this->client = $client;
    }
}
