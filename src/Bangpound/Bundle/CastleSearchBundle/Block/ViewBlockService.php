<?php
namespace Bangpound\Bundle\CastleSearchBundle\Block;

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
abstract class ViewBlockService extends BaseBlockService implements ViewBlockServiceInterface
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

        if ($settings['design_document'] && $settings['view']) {
            $query = $this->manager->createNativeQuery($settings['design_document'], $settings['view']);

            if ($settings['descending']) {
                $query->setDescending(true);
            }

            if ($settings['reduce']) {
                $query->setReduce(true);
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
            'settings'  => $settings
        ), $response);
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
            'design_document' => false,
            'view' => false,
            'descending' => false,
            'reduce' => false,
            'group' => false,
            'group_level' => false,
            'date_format' => 'M-d-Y',
            'date_key' => 0,
            'template' => 'BangpoundCastleSearchBundle:Block:block_view.html.twig',
        ));
    }
}
