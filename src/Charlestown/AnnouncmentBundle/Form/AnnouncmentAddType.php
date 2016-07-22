<?php

namespace Charlestown\AnnouncmentBundle\Form;

use Charlestown\FileBundle\Form\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnouncmentAddType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('type','choice', array(
                                    'choices'   => array('Vente' => 'Vente', 'Achat' => 'Achat', 'Don' => 'Don', 'Echange' => 'Echange' ),'label' => 'Type'))
            ->add('picture', new FileType(), array('label' => 'Photo'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlestown\AnnouncmentBundle\Entity\Announcment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlestown_announcmentbundle_announcment';
    }
}
