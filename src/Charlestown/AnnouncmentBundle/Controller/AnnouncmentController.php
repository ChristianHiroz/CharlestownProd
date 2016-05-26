<?php

namespace Charlestown\AnnouncmentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\AnnouncmentBundle\Entity\Announcment;
use Charlestown\AnnouncmentBundle\Form\AnnouncmentType;

/**
 * Announcment controller.
 *
 * @Route("/annonce")
 */
class AnnouncmentController extends Controller
{

    /**
     * Lists all Announcment entities.
     *
     * @Route("/", name="announcment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->findAll();
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array(
            'announcments' => $entities,
            'user' => $this->getUser(),
            'messages' => $message
        );
    }


    /**
     * Lists all Announcment entities.
     *
     * @Route("/apply/{id}", name="announcment_apply")
     */
    public function applyAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->find($id);

        $user = $this->getUser();
        $entity->setApplicant($user);
        $entity->setVisible(false);
        $user->addOfferApplication($entity);

        $em->persist($user);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('announcment'));
    }

    /**
     * Creates a new Announcment entity.
     *
     * @Route("/", name="announcment_create")
     * @Method("POST")
     * @Template("CharlestownAnnouncmentBundle:Announcment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Announcment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setOfferer($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('announcment'));
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
     * Creates a form to create a Announcment entity.
     *
     * @param Announcment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Announcment $entity)
    {
        $form = $this->createForm(new AnnouncmentType(), $entity, array(
            'action' => $this->generateUrl('announcment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Announcment entity.
     *
     * @Route("/new", name="announcment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Announcment();
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
     * Displays a form to edit an existing Announcment entity.
     *
     * @Route("/{id}/edit", name="announcment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Announcment entity.');
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
    * Creates a form to edit a Announcment entity.
    *
    * @param Announcment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Announcment $entity)
    {
        $form = $this->createForm(new AnnouncmentType(), $entity, array(
            'action' => $this->generateUrl('announcment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing Announcment entity.
     *
     * @Route("/{id}", name="announcment_update")
     * @Method("PUT")
     * @Template("CharlestownAnnouncmentBundle:Announcment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Announcment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('announcment'));
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
     * Deletes a Announcment entity.
     *
     * @Route("/{id}", name="announcment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Announcment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('announcment'));
    }

    /**
     * Creates a form to delete a Announcment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('announcment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
}
