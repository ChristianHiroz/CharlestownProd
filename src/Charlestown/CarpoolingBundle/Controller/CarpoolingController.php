<?php

namespace Charlestown\CarpoolingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\CarpoolingBundle\Entity\Carpooling;
use Charlestown\CarpoolingBundle\Form\CarpoolingType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Carpooling controller.
 *
 * @Route("/covoiturage")
 */
class CarpoolingController extends Controller
{


    /**
     * @Route("/liste", name="carpooling")
     * @Template()
     */
    public function indexAction()
    {
        $carpoolings =  $this->getDoctrine()->getEntityManager()->getRepository('CharlestownCarpoolingBundle:Carpooling')->findAll();

        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        return array('carpoolings' => $carpoolings, 'user' => $this->getUser(), 'now' => new \DateTime(), 'messages' => $message);
    }

    /**
     * @Route("s", name="mycarpoolings")
     * @Template()
     */
    public function myCarpoolingsAction()
    {
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array('carpoolings' => $this->getUser()->getMyCarpoolings(), 'user' => $this->getUser(), 'messages' => $message);
    }

    /**
     * @Route("/demandes", name="mycarpoolings_demand")
     * @Template()
     */
    public function myDemandsAction()
    {
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array('applications' => $this->getUser()->getMyCarpoolingsApplication(), 'selections' => $this->getUser()->getMyCarpoolingsSelection(), 'user' => $this->getUser(), 'messages' => $message);
    }

    /**
     * Creates a new Carpooling entity.
     *
     * @Route("/", name="covoiturage_create")
     * @Method("POST")
     * @Template("CharlestownCarpoolingBundle:Carpooling:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Carpooling();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setDriver($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mycarpoolings'));
        }
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Creates a form to create a Carpooling entity.
     *
     * @param Carpooling $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Carpooling $entity)
    {
        $form = $this->createForm(new CarpoolingType(), $entity, array(
            'action' => $this->generateUrl('covoiturage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Carpooling entity.
     *
     * @Route("/new", name="covoiturage_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Carpooling();
        $form   = $this->createCreateForm($entity);
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Displays a form to edit an existing Carpooling entity.
     *
     * @Route("/{id}/edit", name="covoiturage_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownCarpoolingBundle:Carpooling')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carpooling entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
    * Creates a form to edit a Carpooling entity.
    *
    * @param Carpooling $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Carpooling $entity)
    {
        $form = $this->createForm(new CarpoolingType(), $entity, array(
            'action' => $this->generateUrl('covoiturage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));

        return $form;
    }
    /**
     * Edits an existing Carpooling entity.
     *
     * @Route("/{id}", name="covoiturage_update")
     * @Method("PUT")
     * @Template("CharlestownCarpoolingBundle:Carpooling:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownCarpoolingBundle:Carpooling')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carpooling entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('covoiturage_edit', array('id' => $id)));
        }
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }
    /**
     * Deletes a Carpooling entity.
     *
     * @Route("/{id}", name="covoiturage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CharlestownCarpoolingBundle:Carpooling')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Carpooling entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('covoiturage'));
    }

    /**
     * Creates a form to delete a Carpooling entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('covoiturage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }

    /**
     * @Route("/apply/{id}/{user}", name="apply_carpooling")
     * @Template()
     */
    public function applyAction($id, $user){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $carpooling = $em->getRepository('CharlestownCarpoolingBundle:Carpooling')->find($id);

        $carpooling->addApplicant($user);
        $em->flush();

        return $this->redirect($this->generateUrl('carpooling'));
    }

    /**
     * @Route("/unapply/{id}/{user}", name="unapply_carpooling")
     * @Template()
     */
    public function unapplyAction($id, $user){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $carpooling = $em->getRepository('CharlestownCarpoolingBundle:Carpooling')->find($id);

        if($user->getId() == $this->getUser()->getId() OR $this->getUser()->getId() == $carpooling->getDriver()->getId()){
            $carpooling->removeApplicant($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('carpooling'));
    }

    /**
     * @Route("/select/{id}/{user}", name="select_carpooling")
     * @Template()
     */
    public function selectAction($id, $user){
        $driver = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $carpooling = $em->getRepository('CharlestownCarpoolingBundle:Carpooling')->find($id);


        if($driver->getId() == $carpooling->getDriver()->getId()){
            $carpooling->addSelected($user);
            $carpooling->removeApplicant($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mycarpoolings'));
    }



    /**
     * @Route("/unselect/{id}/{user}", name="unselect_carpooling")
     * @Template()
     */
    public function unselectAction($id, $user){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $carpooling = $em->getRepository('CharlestownCarpoolingBundle:Carpooling')->find($id);

        if($user->getId() == $this->getUser()->getId() OR $this->getUser()->getId() == $carpooling->getDriver()->getId()){
            $carpooling->removeSelected($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mycarpoolings'));
    }
}
