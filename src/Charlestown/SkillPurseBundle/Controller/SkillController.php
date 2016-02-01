<?php

namespace Charlestown\SkillPurseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\SkillPurseBundle\Entity\Skill;
use Charlestown\SkillPurseBundle\Form\SkillType;

/**
 * Skill controller.
 *
 * @Route("/skill")
 */
class SkillController extends Controller
{

    /**
     * Lists all Skill entities.
     *
     * @Route("/", name="skill")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CharlestownSkillPurseBundle:Skill')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Skill entity.
     *
     * @Route("/", name="skill_create")
     * @Method("POST")
     * @Template("CharlestownSkillPurseBundle:Skill:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Skill();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lesson'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser()
        );
    }

    /**
     * Creates a form to create a Skill entity.
     *
     * @param Skill $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Skill $entity)
    {
        $form = $this->createForm(new SkillType(), $entity, array(
            'action' => $this->generateUrl('skill_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Skill entity.
     *
     * @Route("/new", name="skill_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Skill();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser()
        );
    }

    /**
     * Displays a form to edit an existing Skill entity.
     *
     * @Route("/{id}/edit", name="skill_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownSkillPurseBundle:Skill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser()
        );
    }

    /**
    * Creates a form to edit a Skill entity.
    *
    * @param Skill $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Skill $entity)
    {
        $form = $this->createForm(new SkillType(), $entity, array(
            'action' => $this->generateUrl('skill_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));

        return $form;
    }
    /**
     * Edits an existing Skill entity.
     *
     * @Route("/{id}", name="skill_update")
     * @Method("PUT")
     * @Template("CharlestownSkillPurseBundle:Skill:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownSkillPurseBundle:Skill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('skill_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser()
        );
    }
    /**
     * Deletes a Skill entity.
     *
     * @Route("/{id}", name="skill_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CharlestownSkillPurseBundle:Skill')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Skill entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('skill'));
    }

    /**
     * Creates a form to delete a Skill entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('skill_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
}
