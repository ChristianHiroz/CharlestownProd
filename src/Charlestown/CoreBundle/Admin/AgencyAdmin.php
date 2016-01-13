<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AgencyAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('localisation', 'text', array('label' => 'Ville'))
            ->add('customerManager', 'sonata_type_model', array('label' => 'Responsable client','property' => 'username'))
            ->add('eventCustomerManager', 'sonata_type_model', array('label' => 'Responsable client event','property' => 'username'))
            ->add('planningCoordinator', 'sonata_type_model', array('label' => 'Coordinateur planning','property' => 'username'))
            ->add('numeroUrgence')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'Identifiant'))
            ->add('localisation', null, array('label' => 'Ville'))
            ->add('numeroUrgence')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->add('localisation', null, array('label' => 'Ville'))
            ->add('numeroUrgence')
        ;
    }

}