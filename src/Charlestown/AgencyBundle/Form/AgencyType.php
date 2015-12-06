<?php

namespace Charlestown\AgencyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgencyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('localisation')
            ->add('customerManager')
            ->add('eventCustomerManager')
            ->add('planningCoordinator')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlestown\AgencyBundle\Entity\Agency'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlestown_agencybundle_agency';
    }
}
