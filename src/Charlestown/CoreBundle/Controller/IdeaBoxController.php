<?php

namespace Charlestown\CoreBundle\Controller;

use Charlestown\CustomerBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Charlestown\CoreBundle\Entity\IdeaBox;
use Charlestown\CoreBundle\Form\IdeaBoxType;

/**
 * IdeaBox controller.
 *
 * @Route("/ideabox")
 */
class IdeaBoxController extends Controller
{
    /**
     * Creates a new IdeaBox entity.
     *
     * @Route("/", name="ideabox_create")
     * @Method("POST")
     * @Template("CharlestownCoreBundle:IdeaBox:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IdeaBox();
        $user = $this->getUser();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $entity->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('charlestown.mailer')->sendIdeaBoxNotificationMail($user);
            $request->getSession()->set('alert', true);

            return $this->redirect($this->generateUrl('ideabox_new'));
        }



        if($user instanceof Customer){
            return $this->render('CharlestownCoreBundle:IdeaBox:newCustomer.html.twig', array(
                'entity' => $entity,
                'user' => $this->getUser(),
                'form'   => $form->createView(),
            ));
        }
        else{
            return $this->render('CharlestownCoreBundle:IdeaBox:new.html.twig', array(
                'entity' => $entity,
                'user' => $this->getUser(),
                'form'   => $form->createView(),
            ));
        }
    }

    /**
     * Creates a form to create a IdeaBox entity.
     *
     * @param IdeaBox $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IdeaBox $entity)
    {
        $form = $this->createForm(new IdeaBoxType(), $entity, array(
            'action' => $this->generateUrl('ideabox_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer'));

        return $form;
    }

    /**
     * Displays a form to create a new IdeaBox entity.
     *
     * @Route("/new", name="ideabox_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IdeaBox();
        $form   = $this->createCreateForm($entity);
        $user = $this->getUser();

        $alert = $this->get('request')->getSession()->get('alert');
        $this->get('request')->getSession()->set('alert', false);

        if($user instanceof Customer){
            return $this->render('CharlestownCoreBundle:IdeaBox:newCustomer.html.twig', array(
                'entity' => $entity,
                'user' => $this->getUser(),
                'form'   => $form->createView(),
                'alert' => $alert
            ));
        }
        else{
            return $this->render('CharlestownCoreBundle:IdeaBox:new.html.twig', array(
                'entity' => $entity,
                'user' => $this->getUser(),
                'form'   => $form->createView(),
                'alert' => $alert
            ));
        }
    }
}
