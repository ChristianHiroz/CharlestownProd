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
            ->add('start','sonata_type_datetime_picker',array('label'=>'Début', 'format' => 'dd-MM-yyyy HH:mm'))
            ->add('end','sonata_type_datetime_picker',array('label'=>'Fin', 'format' => 'dd-MM-yyyy HH:mm'))
            ->add('rooms','text',array('label'=>'Places'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'Identifiant'))
            ->add('start',null,array('label'=>'Début'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->add('start',null,array('label'=>'Début'))
            ->add('rooms',null,array('label'=>'Places'))

        ;
    }

}