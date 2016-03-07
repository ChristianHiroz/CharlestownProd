<?php

namespace Charlestown\SkillPurseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LessonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startAt', 'date', array('label' => 'Date de début'))
            ->add('endAt', 'date', array('label' => 'Date de fin'))
            ->add('room', 'integer', array('label' => 'Places disponibles'))
            ->add('localisation', 'text', array('label' => 'Lieu'))
            ->add('town', 'text', array('label' => 'Ville'))
            ->add('address', 'text', array('label' => 'Adresse'))
            ->add('pc', 'text', array('label' => 'Code postal'))
            ->add('description', 'textarea', array('label' => 'Description de la formation'))
            ->add('type', 'text', array('label' => 'Type de la formation'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlestown\SkillPurseBundle\Entity\Lesson'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlestown_skillpursebundle_lesson';
    }
}
