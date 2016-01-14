<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OperationAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('brief')
            ->add('type')
            ->add('dateStart',null,array('label'=>'Date de début'))
            ->add('dateEnd',null,array('label'=>'Date de fin'))
            ->add('rooms',null,array('label'=>'Places'))
            ->add('dayLength',null,array('label'=>'Horaires'))
            ->add('mission',null,array('label'=>'Description de la mission'))
            ->add('urlReport',null,array('label'=>'Url du rapport'))
            ->add('localisation', 'text', array('label' => 'Ville'))
            ->add('customer', null, array('label' => 'Client'))
            ->add('agency', null, array('label' => 'Agence'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'Identifiant'))
            ->add('localisation', null, array('label' => 'Ville'))
            ->add('customer', null, array('label' => 'Client'))
            ->add('agency', null, array('label' => 'Agence'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->add('dateStart',null,array('label'=>'Date de début'))
            ->add('dateEnd',null,array('label'=>'Date de fin'))
            ->add('rooms',null,array('label'=>'Places'))
            ->add('localisation', null, array('label' => 'Ville'))
            ->add('customer', null, array('label' => 'Client'))
            ->add('agency', null, array('label' => 'Agence'))
        ;
    }

}