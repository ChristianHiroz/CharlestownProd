<?php

namespace Charlestown\DemandBundle\Controller;

use Charlestown\DemandBundle\Entity\DemandMeeting;
use Charlestown\DemandBundle\Entity\DemandMobility;
use Charlestown\DemandBundle\Entity\DemandFormation;
use Charlestown\DemandBundle\Entity\DemandVacancy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\DemandBundle\Entity\Demand;
use Charlestown\DemandBundle\Form\DemandMeetingType;
use Charlestown\DemandBundle\Form\DemandMobilityType;
use Charlestown\DemandBundle\Form\DemandFormationType;
use Charlestown\DemandBundle\Form\DemandVacancyType;

/**
 * Demand controller.
 *
 * @Route("/demand")
 */
class DemandController extends Controller
{

    /**
     * Lists all Demand entities.
     *
     * @Route("/", name="demand")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CharlestownDemandBundle:Demand')->findAll();
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array(
            'entities' => $entities,
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    //region Meeting
    /**
     * Creates a new Demand entity.
     *
     * @Route("/meeting", name="demand_meeting_create")
     * @Method("POST")
     * @Template("CharlestownDemandBundle:Demand:new.html.twig")
     */
    public function createMeetingAction(Request $request)
    {
        $entity = new DemandMeeting();
        $form = $this->createCreateMeetingForm($entity);
        $form->handleRequest($request);
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();

            $this->get('charlestown.mailer')->sendDemandMail($this->getUser(), "de rendez-vous");

            return $this->redirect($this->generateUrl('demand', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Creates a form to create a Demand entity.
     *
     * @param Demand $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateMeetingForm(DemandMeeting $entity)
    {
        $form = $this->createForm(new DemandMeetingType(), $entity, array(
            'action' => $this->generateUrl('demand_meeting_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Demand entity.
     *
     * @Route("/new_meeting", name="demand_meeting_new")
     * @Method("GET")
     * @Template("CharlestownDemandBundle:Demand:new.html.twig")
     */
    public function newMeetingAction()
    {
        $entity = new DemandMeeting();
        $form   = $this->createCreateMeetingForm($entity);
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Displays a form to edit an existing Demand entity.
     *
     * @Route("/{id}/edit_meeting", name="demand_meeting_edit")
     * @Method("GET")
     * @Template("CharlestownDemandBundle:Demand:edit.html.twig")
     */
    public function editMeetingAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $entity = $em->getRepository('CharlestownDemandBundle:DemandMeeting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Demand entity.');
        }

        $editForm = $this->createEditMeetingForm($entity);
        $deleteForm = $this->createDeleteMeetingForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
    * Creates a form to edit a Demand entity.
    *
    * @param Demand $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditMeetingForm(DemandMeeting $entity)
    {
        $form = $this->createForm(new DemandMeetingType(), $entity, array(
            'action' => $this->generateUrl('demand_meeting_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing Demand entity.
     *
     * @Route("/meeting/{id}", name="demand_meeting_update")
     * @Method("PUT")
     * @Template("CharlestownDemandBundle:Demand:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownDemandBundle:DemandMeeting')->find($id);
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandMeeting entity.');
        }

        $deleteForm = $this->createDeleteMeetingForm($id);
        $editForm = $this->createEditMeetingForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('demand_meeting_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Deletes a Demand entity.
     *
     * @Route("/meeting/{id}", name="demand_meeting_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteMeetingForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CharlestownDemandBundle:DemandMeeting')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DemandMeeting entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('demand'));
    }

    /**
     * Creates a form to delete a Demand entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteMeetingForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demand_meeting_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr' => array('class' => 'btn-danger')))
            ->getForm()
        ;
    }

    //endregion

    //region Mobility
    /**
     * Creates a new DemandMobility entity.
     *
     * @Route("/mobility", name="demand_mobility_create")
     * @Method("POST")
     * @Template("CharlestownDemandBundle:Demand:new.html.twig")
     */
    public function createMobilityAction(Request $request)
    {
        $entity = new DemandMobility();
        $form = $this->createCreateMobilityForm($entity);
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();

            $this->get('charlestown.mailer')->sendDemandMail($this->getUser(), "d'entretien");

            return $this->redirect($this->generateUrl('demand', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Creates a form to create a DemandMobility entity.
     *
     * @param DemandMobility $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateMobilityForm(DemandMobility $entity)
    {
        $form = $this->createForm(new DemandMobilityType(), $entity, array(
            'action' => $this->generateUrl('demand_mobility_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new DemandMobility entity.
     *
     * @Route("/new_mobility", name="demand_mobility_new")
     * @Method("GET")
     * @Template("CharlestownDemandBundle:Demand:new.html.twig")
     */
    public function newMobilityAction()
    {
        $entity = new DemandMobility();
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $form   = $this->createCreateMobilityForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Displays a form to edit an existing Demand entity.
     *
     * @Route("/{id}/edit_mobility", name="demand_mobility_edit")
     * @Method("GET")
     * @Template("CharlestownDemandBundle:Demand:edit.html.twig")
     */
    public function editMobilityAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CharlestownDemandBundle:DemandMobility')->find($id);
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Demand entity.');
        }

        $editForm = $this->createEditMobilityForm($entity);
        $deleteForm = $this->createDeleteMobilityForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
    * Creates a form to edit a Demand Mobility entity.
    *
    * @param Demand $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditMobilityForm(DemandMobility $entity)
    {
        $form = $this->createForm(new DemandMobilityType(), $entity, array(
            'action' => $this->generateUrl('demand_mobility_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing Demand Mobility entity.
     *
     * @Route("/mobility/{id}", name="demand_mobility_update")
     * @Method("PUT")
     * @Template("CharlestownDemandBundle:Demand:edit.html.twig")
     */
    public function updateMobilityAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $entity = $em->getRepository('CharlestownDemandBundle:DemandMobility')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandMobility entity.');
        }

        $deleteForm = $this->createDeleteMobilityForm($id);
        $editForm = $this->createEditMobilityForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('demand_mobility_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Deletes a Demand entity.
     *
     * @Route("/mobility/{id}", name="demand_mobility_delete")
     * @Method("DELETE")
     */
    public function deleteMobilityAction(Request $request, $id)
    {
        $form = $this->createDeleteMobilityForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CharlestownDemandBundle:DemandMobility')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DemandMobility entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('demand'));
    }

    /**
     * Creates a form to delete a Demand Mobility entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteMobilityForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demand_mobility_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr' => array('class' => 'btn-danger')))
            ->getForm()
        ;
    }
    //endregion

    //region Formation
    /**
     * Creates a new Demand Formation entity.
     *
     * @Route("/formation", name="demand_formation_create")
     * @Method("POST")
     * @Template("CharlestownDemandBundle:Demand:new.html.twig")
     */
    public function createFormationAction(Request $request)
    {
        $entity = new DemandFormation();
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $form = $this->createCreateFormationForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();


            $this->get('charlestown.mailer')->sendDemandMail($this->getUser(), "de formation");

            return $this->redirect($this->generateUrl('demand', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Creates a form to create a DemandFormation entity.
     *
     * @param DemandFormation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateFormationForm(DemandFormation $entity)
    {
        $form = $this->createForm(new DemandFormationType(), $entity, array(
            'action' => $this->generateUrl('demand_formation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new DemandFormation entity.
     *
     * @Route("/new_formation", name="demand_formation_new")
     * @Method("GET")
     * @Template("CharlestownDemandBundle:Demand:new.html.twig")
     */
    public function newFormationAction()
    {
        $entity = new DemandFormation();
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $form   = $this->createCreateFormationForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages'=> $message
        );
    }

    /**
     * Displays a form to edit an existing Demand entity.
     *
     * @Route("/{id}/edit_formation", name="demand_formation_edit")
     * @Method("GET")
     * @Template("CharlestownDemandBundle:Demand:edit.html.twig")
     */
    public function editFormationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

        $entity = $em->getRepository('CharlestownDemandBundle:DemandFormation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Demand entity.');
        }

        $editForm = $this->createEditFormationForm($entity);
        $deleteForm = $this->createDeleteFormationForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
    * Creates a form to edit a Demand Formation entity.
    *
    * @param Demand $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditFormationForm(DemandFormation $entity)
    {
        $form = $this->createForm(new DemandFormationType(), $entity, array(
            'action' => $this->generateUrl('demand_formation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing Demand Formation entity.
     *
     * @Route("/formation/{id}", name="demand_formation_update")
     * @Method("PUT")
     * @Template("CharlestownDemandBundle:Demand:edit.html.twig")
     */
    public function updateFormationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $entity = $em->getRepository('CharlestownDemandBundle:DemandFormation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandFormation entity.');
        }

        $deleteForm = $this->createDeleteFormationForm($id);
        $editForm = $this->createEditFormationForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('demand_formation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Deletes a Demand entity.
     *
     * @Route("/formation/{id}", name="demand_formation_delete")
     * @Method("DELETE")
     */
    public function deleteFormationAction(Request $request, $id)
    {
        $form = $this->createDeleteFormationForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CharlestownDemandBundle:DemandFormation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DemandFormation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('demand'));
    }

    /**
     * Creates a form to delete a Demand formation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteFormationForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demand_formation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr' => array('class' => 'btn-danger')))
            ->getForm()
        ;
    }
    //endregion

    //region Vacancy
    /**
     * Creates a new Demand Formation entity.
     *
     * @Route("/vacancy", name="demand_vacancy_create")
     * @Method("POST")
     * @Template("CharlestownDemandBundle:Demand:new.html.twig")
     */
    public function createVacancyAction(Request $request)
    {
        $entity = new DemandVacancy();
        $form = $this->createCreateVacancyForm($entity);
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();


            $this->get('charlestown.mailer')->sendDemandMail($this->getUser(), "de congés");

            return $this->redirect($this->generateUrl('demand', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Creates a form to create a DemandVacancy entity.
     *
     * @param DemandVacancy $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateVacancyForm(DemandVacancy $entity)
    {
        $form = $this->createForm(new DemandVacancyType(), $entity, array(
            'action' => $this->generateUrl('demand_vacancy_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new DemandVacancy entity.
     *
     * @Route("/new_vacancy", name="demand_vacancy_new")
     * @Method("GET")
     * @Template("CharlestownDemandBundle:Demand:new.html.twig")
     */
    public function newVacancyAction()
    {
        $entity = new DemandVacancy();
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $form   = $this->createCreateVacancyForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Displays a form to edit an existing Demand entity.
     *
     * @Route("/{id}/edit_vacancy", name="demand_vacancy_edit")
     * @Method("GET")
     * @Template("CharlestownDemandBundle:Demand:edit.html.twig")
     */
    public function editVacancyAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $entity = $em->getRepository('CharlestownDemandBundle:DemandVacancy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Demand entity.');
        }

        $editForm = $this->createEditVacancyForm($entity);
        $deleteForm = $this->createDeleteVacancyForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
    * Creates a form to edit a Demand Vacancy entity.
    *
    * @param Demand $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditVacancyForm(DemandVacancy $entity)
    {
        $form = $this->createForm(new DemandVacancyType(), $entity, array(
            'action' => $this->generateUrl('demand_vacancy_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing Demand Vacancy entity.
     *
     * @Route("/vacancy/{id}", name="demand_vacancy_update")
     * @Method("PUT")
     * @Template("CharlestownDemandBundle:Demand:edit.html.twig")
     */
    public function updateVacancyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $entity = $em->getRepository('CharlestownDemandBundle:DemandVacancy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandVacancy entity.');
        }

        $deleteForm = $this->createDeleteVacancyForm($id);
        $editForm = $this->createEditVacancyForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('demand_vacancy_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $this->getUser(),
            'messages' => $message
        );
    }

    /**
     * Deletes a Demand entity.
     *
     * @Route("/vacancy/{id}", name="demand_vacancy_delete")
     * @Method("DELETE")
     */
    public function deleteVacancyAction(Request $request, $id)
    {
        $form = $this->createDeleteVacancyForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CharlestownDemandBundle:DemandVacancy')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DemandVacancy entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('demand'));
    }

    /**
     * Creates a form to delete a Demand vacancy entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteVacancyForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demand_vacancy_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr' => array('class' => 'btn-danger')))
            ->getForm()
        ;
    }
    //endregion
}
