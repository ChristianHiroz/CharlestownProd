<?php

namespace Charlestown\CustomerBundle\Controller;

use Charlestown\NotificationBundle\Entity\Notification;
use Charlestown\NotificationBundle\Entity\NotificationUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Charlestown\CustomerBundle\Entity\Devis;

class CustomerController extends Controller

{
    /**
     * @Route("/customer", name="index_customer")
     * @Template()
     */
    public function indexAction()
    {
        if($this->getUser() == null){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        if($this->getUser()->hasRole("ROLE_CUSTOMER")){
            $lasts = $this->getDoctrine()->getManager()->getRepository('CharlestownBlogBundle:Article')->findLastsCustomer();

            return array('user' => $this->getUser(), 'articles' => $lasts);
        }
        else return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/quality", name="quality")
     * @Template()
     */
    public function qualityAction(){
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/qualityService", name="quality_service")
     * @Template()
     */
    public function qualityServiceAction(){
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/setUniforme/{type}/{id}", name="set_uniform")
     * @Template()
     */
    public function setUniformeAction($type,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $notification = new Notification();
        $uniforme = $em->getRepository('CharlestownFileBundle:File')->find($id);
        if($type == "ae"){
            $user->setUniformAE($uniforme);
        }
        else{
            $user->setUniformEvent($uniforme);
        }

        $em->persist($user);
        $em->flush();

        $rcNotification = new NotificationUser();
        $plNotification = new NotificationUser();
        $twNotification = new NotificationUser();

        $notification->setType("Uniforme");
        $notification->setTitle("Changement d'uniforme préféré de " . $user->getCompanyName());
        if($type == "ae"){
        $notification->setDescription("L'uniforme choisi est " . $user->getUniformAE()->getNameShow());
        }
        else{
            $notification->setDescription("L'uniforme choisi est " . $user->getUniformEvent()->getNameShow());
        }

        $notification->setRelativeId($user->getId());

        $agency = $user->getAgency();
        $rcNotification->setNotification($notification);
        $plNotification->setNotification($notification);
        $twNotification->setNotification($notification);

        $rcNotification->setUser($agency->getCustomerManager());
        $plNotification->setUser($agency->getPlanningCoordinator());
        $twNotification->setUser($agency->getThirdWellAccount());

        $rcNotification->setState("unread");
        $plNotification->setState("unread");
        $twNotification->setState("unread");

        $em->persist($notification);
        $em->persist($rcNotification);
        $em->persist($plNotification);
        $em->persist($twNotification);

        $em->flush();

        $this->get('charlestown.mailer')->sendUniformSelectionNotificationMail($this->getUser());

        if($type == "ae"){
            return $this->redirect($this->generateUrl('uniform_ae', array()));
        }
        return $this->redirect($this->generateUrl('uniform_event', array()));
    }

    /**
     * @Route("/uniformesEvent", name="uniform_event")
     * @Template()
     */
    public function uniformEventAction()
    {
        if($this->getUser()->getBook() != null){
            $oldUniformsEvent = $this->getUser()->getBook()->getUniforms();
        }
        else{
            $oldUniformsEvent = false;
        }
        $newUniformsEvent = $this->getDoctrine()->getManager()->getRepository('CharlestownFileBundle:File')->getByFileType('Nouvel uniforme Event');

        return array(
            'user' => $this->getUser(),
            'oldUniformsEvent' => $oldUniformsEvent,
            'newUniformsEvent' => $newUniformsEvent,
        );
    }

    /**
     * @Route("/uniformesAE", name="uniform_ae")
     * @Template()
     */
    public function uniformAEAction()
    {
        $oldUniformsAE = $this->getDoctrine()->getManager()->getRepository('CharlestownFileBundle:File')->getByFileType('Ancien uniforme AE');
        $newUniformsAE = $this->getDoctrine()->getManager()->getRepository('CharlestownFileBundle:File')->getByFileType('Nouvel uniforme AE');

        return array(
            'user' => $this->getUser(),
            'oldUniformsAE' => $oldUniformsAE,
            'newUniformsAE' => $newUniformsAE,
        );
    }

    /**
     * @Route("/customer/operations", name="customer_operation")
     * @Template()
     */
    public function operationAction()
    {
        return array(
            'user' => $this->getUser(),
        );
    }

    /**
     * @Route("/contact", name="social_customer_contact")
     * @Template()
     */
    public function contactAction()
    {
        return array('user' => $this->getUser());
    }

    /**
     * @Route("/factures", name="customer_bills")
     * @Template()
     */
    public function billsAction()
    {
        return array('user' => $this->getUser());
    }

    /**
     * Submit a quality form question
     *
     * @Route("/qualitySubmit", name="quality_submit", options={"expose"=true})
     * @Method("POST")
     */
    public function qualitySubmitAction(Request $request){
        $title = $request->get("title");
        $body = $request->get("body");
        $nom = $request->get("nom");


        $this->get("charlestown.mailer")->sendQualityMail($this->getUser(),$title,$body,$nom);

        return new JsonResponse(array(
            "status" => "ok",
            "message" => "email send"
        ));
    }

    /**
     * Create a devis Entity
     *
     * @Route("/createDevis", name="social_devis_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createDevisAction(Request $request){
        $type = $request->get("type");
        $prestationType = $request->get("typepresta");
        $description = $request->get("description");
        $startAt = $request->get("debut");
        $endAt = $request->get("fin");
        $duree = $request->get("duree");
        $nb = $request->get("nb");

        $devis = new Devis();
        $devis->setDescription($description);
        $devis->setDuree($duree);
        $devis->setEndAt($endAt);
        $devis->setStartAt($startAt);
        $devis->setType($type);
        $devis->setPrestationType($prestationType);
        $devis->setCustomer($this->getUser());
        $devis->setNbHote($nb);

        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();

        $this->get('charlestown.mailer')->sendDevisConfirmationMail($devis);


        return new JsonResponse(array(
            "status" => "ok",
            "message" => "devis created"
        ));
    }

    /**
     * @Route("/devis", name="social_customer_devis")
     * @Template()
     */
    public function devisAction(){
        return array('user' => $this->getUser());
    }
}
