<?php

namespace Charlestown\CoreBundle\Controller;

use Charlestown\CollaboratorBundle\Entity\Collaborator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CoreController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if($user == null){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        if($user->hasRole('ROLE_ADMIN')){
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
        elseif($user->hasRole('ROLE_EVENT')){
            return $this->redirect($this->generateUrl('index_collaborator'));
        }
        elseif($user->hasRole('ROLE_AE')){
            return $this->redirect($this->generateUrl('index_collaborator'));
        }
        elseif($user->hasRole('ROLE_CUSTOMER')){
            return $this->redirect($this->generateUrl('index_customer'));
        }
        elseif($user->hasRole('ROLE_USER')){
            return $this->redirect($this->generateUrl('select_role'));
        }
        else {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

    /**
     * @Route("/admin/sendmail", name="send_mail")
     */
    public function sendMailAction(){
        $user = $this->getUser();
        $this->get('charlestown.mailer')->sendTestMail($user);

        return $this->redirect($this->generateUrl('sonata_admin_dashboard'));

    }

    /**
     * @Route("/CGU", name="cgu")
     * @Template()
     */
    public function cguAction(){
        $user = $this->getUser();

        if($user instanceof Collaborator){
            return array("user" => $user);
        }
        else{
            return $this->render("CharlestownCoreBundle:Core:cguCustomer.html.twig", array("user" => $user));
        }
    }

    /**
     * @Route("/mention", name="mention")
     * @Template()
     */
    public function mentionAction(){
        $user = $this->getUser();

        if($user instanceof Collaborator){
            return array("user" => $user);
        }
        else{
            return $this->render("CharlestownCoreBundle:Core:mentionCustomer.html.twig", array("user" => $user));
        }
    }
}
