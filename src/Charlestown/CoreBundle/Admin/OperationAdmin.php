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
            ->add('name','text',array('label'=>'Nom'))
            ->add('active', 'choice', array(
        'choices' => array(
            1 => 'Oui',
            0 => 'Non'
        ), 'label' => 'Actif'))
            ->add('mission','text',array('label'=>'Description de la mission'))
            ->add('urlReport','text',array('label'=>'Url du rapport'))
            ->add('localisation', 'text', array('label' => 'Adresse'))
            ->add('brief',null,array('label'=>'Brief', 'required' => false))
            ->add('customer', null, array('label' => 'Client'))
            ->add('agency', null, array('label' => 'Agence'))
            ->add('timeslots', 'sonata_type_model', array(
                'label' => 'Horaires', 'multiple' => true, 'by_reference' => false
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
            ->add('localisation', null, array('label' => 'Ville'))
            ->add('customer', null, array('label' => 'Client'))
            ->add('agency', null, array('label' => 'Agence'))
            ->add('timeslots', null, array('label' => 'Horaires'))
        ;
    }

}