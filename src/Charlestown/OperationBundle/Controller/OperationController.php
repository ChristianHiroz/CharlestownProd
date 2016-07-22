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
 */
class OperationController extends Controller
{
    /**
     * @Route("/operation", name="mission_operation")
     * @Template()
     */
    public function indexAction()
    {
        $operations =  $this->getDoctrine()->getManager()->getRepository('CharlestownOperationBundle:Operation')->findBy(array('agency' => $this->getUser()->getAgency()->getId()));
        $user = $this->getUser();
        $appliances = $user->getAppliances();
        $arrayTimeslot = [];
        foreach($appliances as $appliance){
                $arrayTimeslot[] = $appliance->getId().$appliance->getTimeslot()->getId();
        }

        return array('operations' => $operations, 'appliances' => $appliances ,'user' => $user, 'arrayTimeslots' => $arrayTimeslot);
    }

    /**
     * @Route("/operation/apply/{id}/{timeslot}", name="operation_apply")
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
//        $ope = $em->getRepository('CharlestownOperationBundle:OperationAppliance')->find($application->getId());
//        var_dump($ope->getId());exit;


        $this->get('charlestown.mailer')->sendOperationNotificationMail($application);

        $this->get('charlestown.mailer')->sendOperationApplianceMail($application);

        return $this->redirect($this->generateUrl('mission_operation'));
    }

    /**
     * @Route("/operation/removeapply/{id}", name="operation_apply_remove")
     * @Template()
     */
    public function removeApplyOperationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $appliance = $em->getRepository('CharlestownOperationBundle:OperationAppliance')->find($id);
        $timeslot = $appliance->getTimeslot();

        $timeslot->removeAppliance($appliance);
        $user->removeAppliance($appliance);

        $em->remove($appliance);
        $em->persist($user);
        $em->persist($timeslot);
        $em->flush();

        return $this->redirect($this->generateUrl('mission_operation'));
    }
}
