<?php

namespace Charlestown\OperationBundle\Controller;

use Charlestown\OperationBundle\Entity\FileOperation;
use Charlestown\OperationBundle\Entity\Operation;
use Charlestown\OperationBundle\Entity\OperationAppliance;
use Charlestown\OperationBundle\Form\FileOperationType;
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
        $user = $this->getUser();
        $applications = $user->getAppliances();

        return array('operations' => $operations, 'applications' => $applications ,'user' => $user);
    }

    /**
     * @Route("/demandes", name="my_operation_applications")
     * @Template()
     */
    public function myOperationApplicationsAction(Request $request)
    {
        if($request->getSession()->get('alert') == "success"){
            $request->getSession()->set('alert', 'nothing');
            return array('applications' => $this->getUser()->getAppliances(), 'user' => $this->getUser(), 'label' => "success");
        }
        else{
            return array('applications' => $this->getUser()->getAppliances(), 'user' => $this->getUser());
        }
    }

    /**
     * @Route("/historique", name="my_operation_applications_history")
     * @Template()
     */
    public function myOperationApplicationsHistoryAction()
    {

        return array('applications' => $this->getUser()->getAppliances(), 'user' => $this->getUser());
    }

    /**
     * @Route("/show/{id}", name="operation_show")
     * @Template()
     */
    public function showAction($id)
    {
        return array('operation' => $this->getDoctrine()->getManager()->getRepository('CharlestownOperationBundle:Operation')->find($id),'form' => null, 'user' => $this->getUser());
    }

    /**
     * @Route("/apply/{id}/{timeslot}", name="operation_apply")
     * @Template()
     */
    public function applyOperationAction($id, $timeslot)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $operation = $em->getRepository('CharlestownOperationBundle:Operation')->find($id);
        $timeslot = $em->getRepository('CharlestownOperationBundle:Timeslot')->find($timeslot);

        $application = new OperationAppliance();
        $application->setEvent($user);
        $application->setOperation($operation);
        $application->setTimeslot($timeslot);
        $em->persist($application);
        $em->flush();

        $this->get('charlestown.mailer')->sendOperationNotificationMail($application);

        $this->get('charlestown.mailer')->sendOperationApplianceMail($application);

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
