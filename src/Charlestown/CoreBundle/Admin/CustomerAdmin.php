<?php

namespace Charlestown\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CustomerAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $roles = $container->getParameter('security.role_hierarchy.roles');

        $rolesChoices = self::flattenRoles($roles);
        $formMapper
            ->add('username', 'text', array('label' => 'Nom d\'utilisateur'));

        $subject = $this->getSubject();
        if ($subject->getId() == null) {
            // The thumbnail field will only be added when the edited item is created
            $formMapper->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation du mot de passe'),
                'invalid_message' => 'fos_user.password.mismatch',
            ));
        }

        $formMapper
            ->add('email', 'email', array('label' => 'Adresse email', 'attr'=> array('placeholder' => 'Entrez votre adresse email')))
            ->add('roles', 'choice', array(
                    'choices'  => $rolesChoices,
                    'multiple' => true
                )
            )
            ->add('companyName', 'text', array('label' => 'Nom de la société'))
            ->add('siret', 'text', array('label' => 'Numéro SIRET'))
            ->add('address', 'text', array('label' => 'Adresse'))
            ->add('town', 'text', array('label' => 'Ville'))
            ->add('pc', 'text', array('label' => 'Code postal'))
            ->add('phoneNumber', 'text', array('label' => 'Téléphone'))
            ->add('picture')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'Identifiant'))
            ->add('username',null, array('label' => 'Nom d\'utilisateur'))
            ->add('email', null, array('label' => 'Adresse email', 'attr'=> array('placeholder' => 'Entrez votre adresse email')))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null , array('label' => 'Identifiant'))
            ->add('username', null, array('label' => 'Nom d\'utilisateur'))
            ->add('email', null, array('label' => 'Adresse email', 'attr'=> array('placeholder' => 'Entrez votre adresse email')))
        ;
    }

    /**
     * Turns the role's array keys into string <ROLES_NAME> keys.
     */
    protected static function flattenRoles($rolesHierarchy)
    {
        $flatRoles = array();
        foreach($rolesHierarchy as $roles) {

            if(empty($roles)) {
                continue;
            }

            foreach($roles as $role) {
                if(!isset($flatRoles[$role])) {
                    $flatRoles[$role] = $role;
                }
            }
        }

        return $flatRoles;
    }
}