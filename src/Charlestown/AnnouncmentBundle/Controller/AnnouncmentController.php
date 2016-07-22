<?php

namespace Charlestown\AnnouncmentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\AnnouncmentBundle\Entity\Announcment;
use Charlestown\AnnouncmentBundle\Form\AnnouncmentType;
use Charlestown\AnnouncmentBundle\Form\AnnouncmentAddType;

/**
 * Announcment controller.
 *
 */
class AnnouncmentController extends Controller
{

    /**
     * Lists all Announcment entities.
     *
     * @Route("/annonce", name="social_announcment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->findLasts();

        return array(
            'announcments' => $entities,
            'user' => $this->getUser()
        );
    }

    /**
     * Lists all Announcment entities.
     *
     * @Route("/mes_annonces", name="social_my_announcment")
     * @Method("GET")
     * @Template()
     */
    public function myAnnouncmentAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->findBy(array('offerer' => $this->getUser()->getId()));

        return array(
            'announcments' => $entities,
            'user' => $this->getUser()
        );
    }

    /**
     * Lists all Announcment entities that correspond with search option.
     *
     * @Route("/annonce", name="social_announcment_search")
     * @Method("POST")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $type = $request->get('type');
        $name = $request->get('name');
        $town = $request->get('town');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->search($type, $name, $town);

        return $this->render('CharlestownAnnouncmentBundle:Announcment:index.html.twig', array('announcments' => $entities,'user' => $this->getUser()));
    }


    /**
     * Apply to an Announcment entities.
     *
     * @Route("/annonce/apply/{id}", name="social_announcment_apply")
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

        return $this->redirect($this->generateUrl('social_announcment'));
    }



    /**
     * Cancel an apply.
     *
     * @Route("/annonce/unapply/{id}", name="social_announcment_unapply")
     */
    public function unapplyAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->find($id);

        if($this->getUser() == $entity->getOfferer()){
            $entity->setApplicant(null);
            $entity->setVisible(true);
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('social_my_announcment'));
    }

    /**
     * Creates a new Announcment entity.
     *
     * @Route("/annonce", name="social_announcment_create")
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

            return $this->redirect($this->generateUrl('social_announcment'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser()
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
        $form = $this->createForm(new AnnouncmentAddType(), $entity, array(
            'action' => $this->generateUrl('social_announcment_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Announcment entity.
     *
     * @Route("/annonce/new", name="social_announcment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Announcment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
        );
    }

    /**
     * Displays a form to edit an existing Announcment entity.
     *
     * @Route("/annonce/{id}/edit", name="social_announcment_edit")
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

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'user' => $this->getUser()
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
            'action' => $this->generateUrl('social_announcment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        return $form;
    }
    /**
     * Edits an existing Announcment entity.
     *
     * @Route("/annonce/{id}", name="social_announcment_update")
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

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('social_announcment'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'user' => $this->getUser()
        );
    }
    /**
     * Deletes a Announcment entity.
     *
     * @Route("/annonce/{id}", name="social_announcment_delete")
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CharlestownAnnouncmentBundle:Announcment')->find($id);
        if($this->getUser() == $entity->getOfferer()){
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('social_my_announcment'));
    }
}
