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
        return array('name' => 'AE');
    }
}
