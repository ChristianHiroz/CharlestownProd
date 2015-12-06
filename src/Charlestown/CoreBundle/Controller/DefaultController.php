<?php

namespace Charlestown\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
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
        if($user->hasRole('ROLE_EVENT')){
            return $this->redirect($this->generateUrl('index_event'));
        }
        elseif($user->hasRole('ROLE_AE')){
            return $this->redirect($this->generateUrl('index_ae'));
        }
        elseif($user->hasRole('ROLE_CLIENT')){
            return $this->redirect($this->generateUrl('index_client'));
        }
        elseif($user->hasRole('ROLE_ANONYMOUS')){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        else {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }
}
