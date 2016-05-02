<?php

namespace Charlestown\CollaboratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CollaboratorController extends Controller
{

    /**
     * @Route("/collaborateur", name="index_collaborator")
     * @Template()
     */
    public function indexAction()
    {
        if($this->getUser()->hasRole("ROLE_USER")){
            $lasts = $this->getDoctrine()->getManager()->getRepository('CharlestownBlogBundle:Article')->findLasts();
            $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();


            return array('user' => $this->getUser(), 'lastsArticles' => $lasts, 'idActual' => 0, 'messages' => $message);
        }
        else return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/collaborateur/client", name="my_customer")
     * @Template()
     */
    public function myCustomerAction()
    {
        if($this->getUser()->getCustomer() == null){
            return $this->redirect($this->generateUrl('my_agency_contact'));
        }
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/collaborateur/evaluations", name="evaluation")
     * @Template()
     */
    public function evaluationAction()
    {
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/CE", name="ce")
     * @Template()
     */
    public function ceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pv = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV CE");

        return array('pvs' => $pv, 'user' => $this->getUser());
    }
    /**
     * @Route("/contact", name="contact")
     * @Template()
     */
    public function contactAction()
    {
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/agency_contact", name="my_agency_contact")
     * @Template()
     */
    public function myAgencyContactAction()
    {
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/contactSyndicat", name="contact_syndicat")
     * @Template()
     */
    public function contactSyndicatAction()
    {
        $em = $this->getDoctrine()->getManager();
        $syndicats = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->findSyndicated();
        $mandate = $em->getRepository('CharlestownCollaboratorBundle:Mandate')->findAll();

        return array('users' => $syndicats, 'user' => $this->getUser(), 'mandates' => $mandate);
    }

    /**
     * @Route("/changerole", name="change_role_collaborator")
     * @Template()
     */
    public function changeRoleAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if($user->hasRole('ROLE_EVENT')){
            $user->addRole('ROLE_AE');
            $user->removeRole('ROLE_EVENT');
        }
        else{
            $user->addRole('ROLE_EVENT');
            $user->removeRole('ROLE_AE');
        }

        $em->persist($user);
        $em->flush();


        return $this->redirect($this->generateUrl('fos_user_security_logout'));
    }

    /**
     * @Route("/selectrole/{role}", name="select_role")
     * @Template()
     */
    public function selectRoleAction($role = 0)
    {
        $user = $this->getUser();

        if($role == 0){
            return array();
        }
        elseif($role == 1){
            $user = $this->getUser();
            $user->addRole('ROLE_AE');
        }
        elseif($role == 2){
            $user->addRole('ROLE_EVENT');
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('fos_user_security_logout'));
    }


}
