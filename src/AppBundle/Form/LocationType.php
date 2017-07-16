<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class LocationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(0, NumberType::class, ['label' => 'South'])
            ->add(1, NumberType::class, ['label' => 'West'])
            ->add(2, NumberType::class, ['label' => 'North'])
            ->add(3, NumberType::class, ['label' => 'East'])
        ;
    }
}
