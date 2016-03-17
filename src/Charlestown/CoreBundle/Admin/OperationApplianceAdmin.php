<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OperationApplianceAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('event')
            ->add('operation')
            ->add('accepted',null,array('label'=>'Accepté'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'Identifiant'))
            ->add('event', null, array('label' => 'Collaborateur'))
            ->add('operation', null, array('label' => 'Opération'))
            ->add('accepted',null,array('label'=>'Accepté'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->addIdentifier('event', null, array('label' => 'Collaborateur'))
            ->addIdentifier('operation', null, array('label' => 'Opération'))
            ->add('accepted',null,array('label'=>'Accepté'))
        ;
    }

}