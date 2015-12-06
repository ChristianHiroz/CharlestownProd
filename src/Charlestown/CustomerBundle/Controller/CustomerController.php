<?php

namespace Charlestown\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CustomerController extends Controller

{
    /**
     * @Route("/customer")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'Customer');
    }
}
