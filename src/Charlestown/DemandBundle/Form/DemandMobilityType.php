<?php

namespace Charlestown\DemandBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Charlestown\FileBundle\Form\FileType;

class DemandMobilityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', 'choice', array(
                'choices' => array(
                    "Mobilité géographique" => 'Mobilité géographique',
                    "Évolution professionnelle" => 'Évolution professionnelle',
                    "Changement de poste" => 'Changement de poste'
                ), 'label' => 'Motif'))
            ->add('comment','text', array('label' => 'Commentaire'))
            ->add('cV', new FileType(), array('label' => 'Votre CV'))
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
