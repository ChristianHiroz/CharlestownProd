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
            ->add('brief',null,array('label'=>'Brief'))
            ->add('name','text',array('label'=>'Nom'))
            ->add('active', 'choice', array(
        'choices' => array(
            1 => 'Oui',
            0 => 'Non'
        ), 'label' => 'Actif'))
            ->add('type','text',array('label'=>'Type'))
            ->add('dateStart','date',array('label'=>'Date de début'))
            ->add('dateEnd','date',array('label'=>'Date de fin'))
            ->add('rooms','text',array('label'=>'Places'))
            ->add('mission','text',array('label'=>'Description de la mission'))
            ->add('urlReport','text',array('label'=>'Url du rapport'))
            ->add('localisation', 'text', array('label' => 'Ville'))
            ->add('customer', null, array('label' => 'Client'))
            ->add('agency', null, array('label' => 'Agence'))
            ->add('timeslots', 'sonata_type_model', array(
                'label' => 'Horaires', 'multiple' => true
            ))
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
            ->add('name',null,array('label'=>'Nom'))
            ->add('active', 'choice', array(
                'choices' => array(
                    1 => 'Oui',
                    0 => 'Non'
                ), 'label' => 'Actif'))
            ->add('dateStart',null,array('label'=>'Date de début'))
            ->add('dateEnd',null,array('label'=>'Date de fin'))
            ->add('rooms',null,array('label'=>'Places'))
            ->add('localisation', null, array('label' => 'Ville'))
            ->add('customer', null, array('label' => 'Client'))
            ->add('agency', null, array('label' => 'Agence'))
        ;
    }

}