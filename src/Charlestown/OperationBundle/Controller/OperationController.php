<?php

namespace Charlestown\OperationBundle\Controller;

use Charlestown\OperationBundle\Entity\Operation;
use Charlestown\OperationBundle\Entity\OperationAppliance;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\CarpoolingBundle\Entity\Carpooling;
use Charlestown\CarpoolingBundle\Form\CarpoolingType;

/**
 * Operation controller.
 *
 * @Route("/operation")
 */
class OperationController extends Controller
{


    /**
     * @Route("/liste", name="operation")
     * @Template()
     */
    public function indexAction()
    {
        $operations =  $this->getDoctrine()->getManager()->getRepository('CharlestownOperationBundle:Operation')->findAll();

        return array('operations' => $operations, 'user' => $this->getUser());
    }

    /**
     * @Route("/demandes", name="my_operation_applications")
     * @Template()
     */
    public function myOperationApplicationsAction()
    {
        return array('applications' => $this->getUser()->getAppliances(), 'user' => $this->getUser());
    }

    /**
     * @Route("/show/{id}", name="operation_show")
     * @Template()
     */
    public function showAction($id)
    {
        return array('operation' => $this->getDoctrine()->getManager()->getRepository('CharlestownOperationBundle:Operation')->find($id), 'user' => $this->getUser());
    }

    /**
     * @Route("/apply/{id}", name="operation_apply")
     * @Template()
     */
    public function applyOperationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $operation = $em->getRepository('CharlestownOperationBundle:Operation')->find($id);

        $application = new OperationAppliance();
        $application->setEvent($user);
        $application->setOperation($operation);
        $em->persist($application);
        $em->flush();


        return $this->redirect($this->generateUrl('my_operation_applications'));
    }

    /**
     * @Route("/removeapply/{id}", name="operation_apply_remove")
     * @Template()
     */
    public function removeApplyOperationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $appliance = $em->getRepository('CharlestownOperationBundle:OperationAppliance')->find($id);
        $operation = $appliance->getOperation();

        $operation->removeAppliance($appliance);
        $user->removeAppliance($appliance);

        $em->remove($appliance);
        $em->persist($user);
        $em->persist($operation);
        $em->flush();

        return $this->redirect($this->generateUrl('my_operation_applications'));
    }
}
