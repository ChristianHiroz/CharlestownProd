<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FileOperationAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('accepted')
            ->add('name')
            ->add('operation')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->addIdentifier('id')
            ->add('name')
            ->add('nameShow')
            ->add('accepted')
            ->add('operation')
            ->add('alt')
            ->add('date')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if($this->hasParentFieldDescription()) { // this Admin is embedded
            // $getter will be something like 'getlogoImage'
            $getter = 'get' . $this->getParentFieldDescription()->getFieldName();

            // get hold of the parent object
            $parent = $this->getParentFieldDescription()->getAdmin()->getSubject();
            if ($parent) {
                $image = $parent->$getter();
            } else {
                $image = null;
            }
        } else {
            $image = $this->getSubject();
        }
        $fileFieldOptions = array('required' => false);
        if ($image && ($webPath = $image->getAbsolutePath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
        }

        $formMapper->add('file', 'file', $fileFieldOptions)
                    ->add('nameShow')
                    ->add('accepted', 'choice', array(
                        'choices' => array(
                            1 => 'Oui',
                            0 => 'Non'
                        )))
                    ->add('operation');
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('file', 'file')
            ->add('alt')
            ->add('operation')
            ->add('accepted')
        ;
    }
}
