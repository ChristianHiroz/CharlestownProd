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

        if($this->getUser() == null) {
            return $this->redirect($this->generateUrl('index'));
        }
        elseif($this->getUser()->hasRole("ROLE_CUSTOMER")){
        return $this->redirect($this->generateUrl('index'));
        }
        elseif($this->getUser()->hasRole("ROLE_USER")){
            $articles = $this->getDoctrine()->getManager()->getRepository('CharlestownBlogBundle:Article')->findLastsCollaborator();

            return array('user' => $this->getUser(), 'articles' => $articles);
        }
        else return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/mission", name="mission_collaborator")
     * @Template()
     */
    public function missionAction()
    {
        if($this->getUser() == null) {
            return $this->redirect($this->generateUrl('index'));
        }
        elseif($this->getUser()->hasRole("ROLE_CUSTOMER")){
        return $this->redirect($this->generateUrl('index'));
        }
        elseif($this->getUser()->hasRole("ROLE_USER")){

            return array('user' => $this->getUser());
        }
        else return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/affectation", name="mission_client")
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
     * @Route("/evaluations", name="mission_evaluation")
     * @Template()
     */
    public function evaluationAction()
    {
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/infos", name="info_contact")
     * @Template()
     */
    public function contactAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pvsCE = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV CE");
        $pvsCHSCT = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV CHSCT");
        $pvsDPParis = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV CE");
        $pvsDPLyon = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV DP Lyon");
        $pvsDPNantes = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV DP Nantes");
        $pvsDPBordeaux = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV DP Bordeaux");
        $pvsDPMarseille = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV DP Marseille");
        $pvsDPLille = $em->getRepository('CharlestownFileBundle:File')->getByFileType("PV DP Lille");
        $syndicats = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->findSyndicated();
        $mandate = $em->getRepository('CharlestownCollaboratorBundle:Mandate')->findAll();
        return array(
            'user' => $this->getUser(),
            'mandates' => $mandate,
            'users' => $syndicats,
            "pvsCE" => $pvsCE,
            "pvsDPLyon" => $pvsDPLyon,
            "pvsDPParis" => $pvsDPParis,
            "pvsDPNantes" => $pvsDPNantes,
            "pvsDPMarseille" => $pvsDPMarseille,
            "pvsDPBordeaux" => $pvsDPBordeaux,
            "pvsDPLille" => $pvsDPLille,
            "pvsCHSCT" => $pvsCHSCT,
            );
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
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array('users' => $syndicats, 'user' => $this->getUser(), 'mandates' => $mandate, 'messages' => $message);
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
