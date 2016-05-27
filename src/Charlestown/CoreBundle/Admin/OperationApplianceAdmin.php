<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class OperationApplianceAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('event')
            ->add('operation')
            ->add('timeslot',null,array('label' => 'Créneau'))
            ->add('accepted', 'choice', array(
                'choices' => array(
                    1 => 'Oui',
                    0 => 'Non'
                ), 'label' => 'Accepter'))
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
            ->add('event', null, array('label' => 'Collaborateur'))
            ->add('operation', null, array('label' => 'Opération'))
            ->add('timeslot',null,array('label' => 'Créneau'))
            ->add('accepted',null,array('label'=>'Accepté'))
        ;
    }

    public function getExportFields() {
        $exportFields = array();

        $exportFields['Nom'] = 'event.firstName';
        $exportFields['Prénom'] = 'event.lastName';
        $exportFields['Téléphone'] = 'event.phoneNumber';
        $exportFields['Email'] = 'event.email';
        $exportFields['Horaire'] = 'timeslot';

        return $exportFields;
    }

    public function getExportFormats()
    {
        return array(
            'xls'
        );
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('edit', null, array(), array(), array( 'expose' => true ));
    }

}