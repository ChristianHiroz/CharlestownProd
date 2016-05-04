<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MessageAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('message', 'text', array('label' => 'Message'))
            ->add('writer', 'sonata_type_model', array('label' => 'Utilisateur'))
            ->add('writedAt', 'datetime', array('label' => 'Date d\'envoi'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('writer', null, array('label' => 'Utilisateur'))
            ->add('writedAt', null, array('label' => 'Date d\'envoi'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->add('writer', null, array('label' => 'Utilisateur'))
            ->add('writedAt', null, array('label' => 'Date d\'envoi'))
        ;
    }

}