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
 */
class LessonController extends Controller
{

    /**
     * Lists all Lesson entities.
     *
     * @Route("/bourse", name="social_lesson")
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
     * @Route("/bourses", name="social_my_lesson")
     * @Template()
     */
    public function myLessonsAction()
    {
        return array('lessons' => $this->getUser()->getMyLessons(), 'user' => $this->getUser());
    }

    /**
     * @Route("/bourse_demandes", name="social_lesson_applications")
     * @Template()
     */
    public function myLessonsApplicationsAction()
    {
        return array('lessons' => $this->getUser()->getLessons(),'lessonsApplications' => $this->getUser()->getMyLessonsApplication(), 'user' => $this->getUser());
    }


    /**
     * Creates a new Lesson entity.
     *
     * @Route("/bourses", name="social_lesson_create")
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

            return $this->redirect($this->generateUrl('social_my_lesson'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser()
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
            'action' => $this->generateUrl('social_lesson_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Lesson entity.
     *
     * @Route("/bourse/new", name="social_lesson_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lesson();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser()
        );
    }

    /**
     * Displays a form to edit an existing Lesson entity.
     *
     * @Route("/bourse/{id}/edit", name="social_lesson_edit")
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

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser()
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
            'action' => $this->generateUrl('social_lesson_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Lesson entity.
     *
     * @Route("/bourse/{id}", name="social_lesson_update")
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

            return $this->redirect($this->generateUrl('social_lesson_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser()
        );
    }
    /**
     * Deletes a Lesson entity.
     *
     * @Route("/bourse/{id}", name="social_lesson_delete")
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

        return $this->redirect($this->generateUrl('social_my_lesson'));
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
            ->setAction($this->generateUrl('social_lesson_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer mon cours', 'attr' => array("class" => "btn btn-large btn-danger", "style" => "width : 100%;")))
            ->getForm()
        ;
    }

    /**
     * @Route("/bourse/apply/{id}/{user}", name="apply_lesson")
     * @Template()
     */
    public function applyAction($id, $user){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find($user);
        $lesson = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->find($id);

        $lesson->addStudentApplicant($user);
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('social_lesson_applications'));
    }

    /**
     * @Route("/bourse/unapply/{id}/{user}", name="unapply_lesson")
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

        return $this->redirect($this->generateUrl('social_lesson_applications'));
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

        return $this->redirect($this->generateUrl('social_my_lesson'));
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

        return $this->redirect($this->generateUrl('social_my_lesson'));
    }

    /**
     * Lists all Announcment entities that correspond with search option.
     *
     * @Route("/bourse", name="social_lesson_search")
     * @Method("POST")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $name = $request->get('name');
        $town = $request->get('town');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CharlestownSkillPurseBundle:Lesson')->search($name, $town);

        return $this->render('CharlestownSkillPurseBundle:Lesson:index.html.twig', array('lessons' => $entities,'user' => $this->getUser()));
    }
}
