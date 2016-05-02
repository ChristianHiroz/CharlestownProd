<?php

namespace Charlestown\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdeaBoxType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Titre de l\'idée'))
            ->add('description', 'textarea', array('label' => 'Description de l\'idée'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlestown\CoreBundle\Entity\IdeaBox'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlestown_corebundle_ideabox';
    }
}
