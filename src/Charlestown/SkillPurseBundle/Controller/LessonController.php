<?php

namespace Charlestown\SkillPurseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\SkillPurseBundle\Entity\Lesson;
use Charlestown\SkillPurseBundle\Form\LessonType;

/**
 * Lesson controller.
 *
 * @Route("/lesson")
 */
class LessonController extends Controller
{

    /**
     * Lists all Lesson entities.
     *
     * @Route("/", name="lesson")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->findAll();

        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array(
            'lessons' => $entities,
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * @Route("s", name="mylessons")
     * @Template()
     */
    public function myLessonsAction()
    {
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array('lessons' => $this->getUser()->getMyLessons(), 'user' => $this->getUser(), 'messages' => $message);
    }

    /**
     * @Route("/demandes", name="mylesson_applications")
     * @Template()
     */
    public function myLessonsApplicationsAction()
    {
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array('messages' => $message, 'lessons' => $this->getUser()->getLessons(),'lessonsApplications' => $this->getUser()->getMyLessonsApplication(), 'user' => $this->getUser());
    }


    /**
     * Creates a new Lesson entity.
     *
     * @Route("/", name="lesson_create")
     * @Method("POST")
     * @Template("CharlestownSkillPurseBundle:Lesson:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lesson();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setTeacher($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mylessons'));
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
     * Creates a form to create a Lesson entity.
     *
     * @param Lesson $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Lesson $entity)
    {
        $form = $this->createForm(new LessonType(), $entity, array(
            'action' => $this->generateUrl('lesson_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Lesson entity.
     *
     * @Route("/new", name="lesson_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lesson();
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
     * Displays a form to edit an existing Lesson entity.
     *
     * @Route("/{id}/edit", name="lesson_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
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
    * Creates a form to edit a Lesson entity.
    *
    * @param Lesson $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lesson $entity)
    {
        $form = $this->createForm(new LessonType(), $entity, array(
            'action' => $this->generateUrl('lesson_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));

        return $form;
    }
    /**
     * Edits an existing Lesson entity.
     *
     * @Route("/{id}", name="lesson_update")
     * @Method("PUT")
     * @Template("CharlestownSkillPurseBundle:Lesson:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lesson_edit', array('id' => $id)));
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
     * Deletes a Lesson entity.
     *
     * @Route("/{id}", name="lesson_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lesson entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lesson'));
    }

    /**
     * Creates a form to delete a Lesson entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lesson_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }

    /**
     * @Route("/apply/{id}/{user}", name="apply_lesson")
     * @Template()
     */
    public function applyAction($id, $user){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $lesson = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->find($id);

        $lesson->addStudentApplicant($user);
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('lesson'));
    }

    /**
     * @Route("/unapply/{id}/{user}", name="unapply_lesson")
     * @Template()
     */
    public function unapplyAction($id, $user){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $lesson = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->find($id);

        if($user->getId() == $this->getUser()->getId() OR $this->getUser()->getId() == $lesson->getTeacher()->getId()){
            $lesson->removeApplicant($user);
            $em->persist($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lesson'));
    }

    /**
     * @Route("/select/{id}/{user}", name="select_lesson")
     * @Template()
     */
    public function selectAction($id, $user){
        $driver = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $lesson = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->find($id);


        if($driver->getId() == $lesson->getTeacher()->getId()){
            $lesson->addStudent($user);
            $lesson->removeApplicant($user);
            $em->persist($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lesson'));
    }



    /**
     * @Route("/unselect/{id}/{user}", name="unselect_lesson")
     * @Template()
     */
    public function unselectAction($id, $user){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $lesson = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->find($id);

        if($user->getId() == $this->getUser()->getId() OR $this->getUser()->getId() == $lesson->getTeacher()->getId()){
            $lesson->removeSelected($user);
            $em->persist($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lesson'));
    }
}
