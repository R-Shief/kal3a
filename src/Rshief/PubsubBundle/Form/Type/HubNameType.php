<?php

namespace Rshief\PubsubBundle\Form\Type;

use Sputnik\Bundle\PubsubBundle\Hub\HubProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class HubNameType
 * @package Rshief\PubsubBundle\Form\Type
 */
class HubNameType extends AbstractType
{
    private $provider;

    /**
     * @param HubProviderInterface $provider
     */
    public function __construct(HubProviderInterface $provider) {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent() {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'hub_name';
    }


    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $provider = $this->provider;

        $resolver->setDefaults(array(
            'context'           => false,
            'multiple'          => false,
            'expanded'          => false,
            'choices'           => function (Options $options, $previousValue) use ($provider) {

                $choices = array();
                foreach ($provider->getHubs() as $hub) {
                  $choices[$hub->getName()] = $hub->getName();
                }

                if (empty($choices)) {
                    throw new FormException('Please define a provider.');
                }

                return $choices;
            },
            'preferred_choices' => array(),
            'empty_data'        => function (Options $options) {
                $multiple = isset($options['multiple']) && $options['multiple'];
                $expanded = isset($options['expanded']) && $options['expanded'];

                return $multiple || $expanded ? array() : '';
            },
            'empty_value'       => function (Options $options, $previousValue) {
                $multiple = isset($options['multiple']) && $options['multiple'];
                $expanded = isset($options['expanded']) && $options['expanded'];

                return $multiple || $expanded || !isset($previousValue) ? null : '';
            },
            'error_bubbling'    => false,
        ));
    }
}
