<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class IdeaBoxAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('user', null, array('label' => 'Utilisateur'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array('label' => 'Titre'))
            ->add('user', null, array('label' => 'Utilisateur'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->add('title', null, array('label' => 'Titre'))
            ->add('user', null, array('label' => 'Utilisateur'))
        ;
    }

}