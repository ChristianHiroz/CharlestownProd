<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TimeslotAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('start',null,array('label'=>'Début'))
            ->add('end',null,array('label'=>'Fin'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'Identifiant'))
            ->add('start',null,array('label'=>'Début'))
            ->add('end',null,array('label'=>'Fin'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->add('start',null,array('label'=>'Début'))
            ->add('end',null,array('label'=>'Fin'))
        ;
    }

}