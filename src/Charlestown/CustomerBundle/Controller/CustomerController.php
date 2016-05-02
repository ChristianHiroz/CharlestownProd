<?php

namespace Charlestown\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        if($this->getUser()->hasRole("ROLE_USER")){
            $lasts = $this->getDoctrine()->getManager()->getRepository('CharlestownBlogBundle:Article')->findLasts();

            return array('user' => $this->getUser(), 'lastsArticles' => $lasts, 'idActual' => 0);
        }
        else return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/rse", name="rse")
     * @Template()
     */
    public function rseAction()
    {
        if($this->getUser()->hasRole("ROLE_USER")){
            $lasts = $this->getDoctrine()->getManager()->getRepository('CharlestownBlogBundle:Article')->findLasts();

            return array('user' => $this->getUser(), 'lastsArticles' => $lasts, 'idActual' => 0);
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
        $uniforme = $em->getRepository('CharlestownFileBundle:File')->find($id);
        if($type == "ae"){
            $user->setUniformAE($uniforme);
        }
        else{
            $user->setUniformEvent($uniforme);
        }

        $em->persist($user);
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
     * @Route("/customer/contact", name="customer_contact")
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
     * Creates a new Relance entity with ajax.
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
     * @Route("/devis", name="customer_devis")
     * @Template()
     */
    public function devisAction(){
        return array('user' => $this->getUser());
    }
}
