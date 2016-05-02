<?php

namespace Charlestown\AgencyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Agency controller.
 *
 * @Route("/agency")
 */
class AgencyController extends Controller
{

    /**
     * @Route("/calendar", name="agency_calendar")
     * @Template()
     */
    public function calendarAction()
    {
        return array('user' => $this->getUser());
    }
}
