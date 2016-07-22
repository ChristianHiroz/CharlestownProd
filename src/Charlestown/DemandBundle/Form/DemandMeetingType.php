<?php

namespace Charlestown\DemandBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DemandMeetingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason','text', array('label' => 'Motif'))
            ->add('comment','text', array('label' => 'Commentaire'))
            ->add('disponibility','choice', array(
                'choices'   => array('Pendant temps de travail' => 'Pendant temps de travail',
                    'Hors du temps de travail' => 'Hors du temps de travail',
                    'Peut importe' => 'Peut importe'), 'label' => "Disponibilité"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlestown\DemandBundle\Entity\Demand'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlestown_demandbundle_demand';
    }
}
