<?php

namespace Charlestown\CarpoolingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarpoolingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateTravel', 'date', array('label' => 'Date de départ'))
            ->add('room', 'integer', array('label' => 'Nombre de places'))
            ->add('startPlace', 'text', array('label' => 'Lieu de départ'))
            ->add('endPlace', 'text', array('label' => 'Lieu d\'arrivé'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlestown\CarpoolingBundle\Entity\Carpooling'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlestown_carpoolingbundle_carpooling';
    }
}
