<?php

namespace Charlestown\OperationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\OperationBundle\Entity\FileOperation;
use Charlestown\OperationBundle\Form\FileOperationType;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * FileOperation controller.
 *
 * @Route("/fileoperation")
 */
class FileOperationController extends Controller
{
    /**
     * Creates a new FileOperation entity.
     *
     * @Route("/", name="fileoperation_create")
     * @Method("POST")
     * @Template("CharlestownOperationBundle:FileOperation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FileOperation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $operation = $em->getRepository('CharlestownOperationBundle:Operation')->find($request->getSession()->get('operation'));

            if($operation){
                $entity->setEvent($this->getUser());
                $entity->setOperation($operation);
                $em->persist($entity);
                $em->flush();

                $request->getSession()->set('alert', 'success');
            }
            return $this->redirect($this->generateUrl('my_operation_applications'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
        );
    }

    /**
     * Creates a form to create a FileOperation entity.
     *
     * @param FileOperation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FileOperation $entity)
    {
        $form = $this->createForm(new FileOperationType(), $entity, array(
            'action' => $this->generateUrl('fileoperation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyé'));

        return $form;
    }

    /**
     * Displays a form to create a new FileOperation entity.
     *
     * @Route("/new/{operation}", name="fileoperation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($operation, Request $request)
    {
        $session =  $request->getSession();

        $session->set('operation', $operation);

        $entity = new FileOperation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $this->getUser(),
        );
    }
}
