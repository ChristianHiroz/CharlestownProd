<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class DemandMobilityAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('reason', 'text', array('label' => 'Motif'))
            ->add('status', 'text', array('label' => 'Status'))
            ->add('dateDemand', 'date', array('label' => 'Date de la demande'))
            ->add('dateResponse', 'date', array('label' => 'Date de la réponse'))
            ->add('response', 'text', array('label' => 'Réponse'))
            ->add('responseStatus', 'text', array('label' => 'Réponse status'))
            ->add('comment', 'text', array('label' => 'Commentaire de la réponse'))
            ->add('cV', 'sonata_type_model', array('label' => 'CV', 'property' => 'name'))
            ->add('user', null, array('label' => 'Utilisateur','property' => 'username'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('reason', null, array('label' => 'Motif'))
            ->add('status', null, array('label' => 'Status'))
            ->add('dateDemand', null, array('label' => 'Date de la demande'))
            ->add('dateResponse', null, array('label' => 'Date de la réponse'))
            ->add('response', null, array('label' => 'Réponse'))
            ->add('responseStatus', null, array('label' => 'Réponse status'))
            ->add('cV', null, array('label' => 'CV', 'property' => 'name'))
            ->add('user', null, array('label' => 'Utilisateur','property' => 'username'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('reason', null, array('label' => 'Motif'))
            ->add('status', null, array('label' => 'Status'))
            ->add('dateDemand', null, array('label' => 'Date de la demande'))
            ->add('dateResponse', null, array('label' => 'Date de la réponse'))
            ->add('response', null, array('label' => 'Réponse'))
            ->add('responseStatus', null, array('label' => 'Réponse status'))
            ->add('cV', null, array('label' => 'CV', 'property' => 'name'))
            ->addIdentifier('user', null, array('label' => 'Utilisateur','property' => 'username'))
        ;
    }
}
