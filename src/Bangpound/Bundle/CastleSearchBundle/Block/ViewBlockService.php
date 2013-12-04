<?php
namespace Bangpound\Bundle\CastleSearchBundle\Block;

use Doctrine\CouchDB\View\Query;
use Doctrine\ODM\CouchDB\DocumentManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ViewBlockService
 * @package Bangpound\Bundle\CastleSearchBundle\Block
 */
class ViewBlockService extends BaseBlockService implements ViewBlockServiceInterface
{
    protected $manager;

    /**
     * @param string          $name
     * @param EngineInterface $templating
     * @param DocumentManager $manager
     */
    public function __construct($name, EngineInterface $templating, DocumentManager $manager)
    {
        parent::__construct($name, $templating);
        $this->manager = $manager;
    }

    /**
     * @param FormMapper     $form
     * @param BlockInterface $block
     *
     * @return void
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('design_document', 'text', array('required' => true)),
                array('view', 'text', array('required' => false)),
                array('stale', 'checkbox'),
                array('descending', 'checkbox'),
                array('reduce', 'checkbox'),
                array('group', 'checkbox'),
                array('group_level', 'integer'),
            )
        ));
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response              $response
     *
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $query = $this->query($blockContext);

        if ($query) {

            if ($settings['stale']) {
                $query->setStale(true);
            }

            if ($settings['limit']) {
                $query->setLimit($settings['limit']);
            }

            if ($settings['descending']) {
                $query->setDescending(true);
            }

            if ($settings['reduce']) {
                $query->setReduce(true);
            }

            if ($settings['key']) {
                $query->setKey($settings['key']);
            }

            if ($settings['keys']) {
                $query->setKeys($settings['keys']);
            }

            if ($settings['startkey']) {
                $query->setStartKey($settings['startkey']);
            }

            if ($settings['endkey']) {
                $query->setEndKey($settings['endkey']);
            }

            if ($settings['group']) {
                $query->setGroup(true);
                $query->setGroupLevel($settings['group_level']);
            }

            $results = $this->results($query, $blockContext);
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'query'     => $query,
            'results'   => $results,
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings,
        ), $response);
    }

    /**
     * @param  BlockContextInterface                     $blockContext
     * @return \Doctrine\CouchDB\View\AbstractQuery|null
     */
    public function query(BlockContextInterface $blockContext)
    {
        $settings = $blockContext->getSettings();
        $query = $this->manager->createNativeQuery($settings['design_document'], $settings['view']);

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
        $resolver->setDefaults(array(
            'title' => null,
            'body' => null,
            'design_document' => false,
            'view' => false,
            'key' => false,
            'keys' => false,
            'startkey' => false,
            'endkey' => false,
            'limit' => null,
            'descending' => false,
            'reduce' => false,
            'group' => false,
            'group_level' => false,
            'stale' => false,
            'template' => 'BangpoundCastleSearchBundle:Block:block_view.html.twig',
        ));
    }

    /**
     * @param  Query                 $query
     * @param  BlockContextInterface $blockContext
     * @return mixed
     */
    public function results(Query $query, BlockContextInterface $blockContext)
    {
        $results = array();
        foreach ($query->execute() as $result) {
            $results[$result['key'][0]] = $result['value'];
        }

        return $results;
    }
}
