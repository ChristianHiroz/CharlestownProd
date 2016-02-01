<?php

namespace Charlestown\CollaboratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BusinessSupportController extends Controller
{
    /**
     * @Route("/ae", name="index_ae")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'AE', 'user' => $this->getUser());
    }

    /**
     * @Route("/ae/customer", name="my_customer")
     * @Template()
     */
    public function myCustomerAction()
    {
        if($this->getUser()->getCustomer() == null){
            return $this->redirect($this->generateUrl('my_customer_contact'));
        }
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/ae/customer/contact", name="my_customer_contact")
     * @Template()
     */
    public function myCustomerContactAction()
    {
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/ae/evaluations", name="evaluation")
     * @Template()
     */
    public function evaluationAction()
    {
        return array('user' => $this->getUser());
    }
}
