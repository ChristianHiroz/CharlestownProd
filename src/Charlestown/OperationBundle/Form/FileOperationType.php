<?php

namespace Charlestown\OperationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileOperationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameShow', 'text', array('label' =>'Nom du fichier'))
            ->add('file', 'file', array('label' => 'Fichier'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Charlestown\OperationBundle\Entity\FileOperation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'charlestown_operationbundle_fileoperation';
    }
}
