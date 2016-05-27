<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class DevisAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('duree', 'text', array('label' => 'Durée'))
            ->add('startAt', 'text', array('label' => 'Heure début'))
            ->add('endAt', 'text', array('label' => 'Heure fin'))
            ->add('nbHote', 'text', array('label' => 'Nombre d\'hôtes'))
            ->add('description', 'text', array('label' => 'Description du poste'))
            ->add('type', 'text', array('label' => 'Type de devis'))
            ->add('prestationType', 'text', array('label' => 'Type de préstation'))
            ->add('customer', 'sonata_type_model', array('label' => 'Client'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type', null, array('label' => 'Type de devis'))
            ->add('prestationType', null, array('label' => 'Type de préstation'))
            ->add('customer', null, array('label' => 'Client'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'Identifiant'))
            ->add('type', null, array('label' => 'Type de devis'))
            ->add('prestationType', null, array('label' => 'Type de préstation'))
            ->add('customer', null, array('label' => 'Client'))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('edit', null, array(), array(), array( 'expose' => true ));
    }

}