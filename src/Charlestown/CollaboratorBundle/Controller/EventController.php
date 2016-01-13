<?php

namespace Charlestown\CollaboratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EventController extends Controller
{
    /**
     * @Route("/event", name="index_event")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'Event', 'user' => $this->getUser());
    }
}
