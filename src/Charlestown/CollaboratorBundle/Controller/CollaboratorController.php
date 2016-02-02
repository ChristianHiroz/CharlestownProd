<?php

namespace Charlestown\CollaboratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CollaboratorController extends Controller
{
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
}
