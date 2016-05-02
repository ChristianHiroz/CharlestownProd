<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('texte', 'textarea', array('label' => 'Corps'))
            ->add('picture', 'sonata_type_model', array('label' => 'Image'))
            ->add('visibleCollaborator', 'choice', array(
                'choices' => array(
                    0 => 'Non',
                    1 => 'Oui'
                ), 'label' => 'Afficher aux collaborateurs'))
            ->add('visibleCustomer', 'choice', array(
                'choices' => array(
                    0 => 'Non',
                    1 => 'Oui'
                ), 'label' => 'Afficher aux clients'))
            ->add('action', 'choice', array(
                'choices' => array(
                    0 => 'Non',
                    1 => 'Oui'
                ), 'label' => 'Afficher dans actions'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array('label' => 'Titre'))
            ->add('texte', null, array('label' => 'Corps'))
            ->add('picture', null, array('label' => 'Image'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->add('title', null, array('label' => 'Titre'))
            ->add('texte', null, array('label' => 'Corps'))
            ->add('picture', null, array('label' => 'Image'))
        ;
    }

}