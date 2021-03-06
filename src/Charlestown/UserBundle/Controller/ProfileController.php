<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charlestown\UserBundle\Controller;

use Charlestown\FileBundle\Entity\File;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Proxies\__CG__\Charlestown\CollaboratorBundle\Entity\Collaborator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showAction()
    {
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if($user->hasRole('ROLE_CUSTOMER')){
            return $this->render('FOSUserBundle:Profile:showCustomer.html.twig', array(
                'user' => $user
            ));
        }
        else{
            return $this->render('FOSUserBundle:Profile:show.html.twig', array(
                'user' => $user, 'messages' => $message
            ));
        }
    }

    public function showOtherAction($user){

        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CharlestownUserBundle:User')->find($user);
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('FOSUserBundle:Profile:showOther.html.twig', array(
            'user' => $user, 'messages' => $message
        ));
    }

    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $message = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        if($user->hasRole("ROLE_AE") || $user->hasRole("ROLE_EVENT")){
            return $this->render('CharlestownUserBundle:Profile:edit.html.twig', array(
                'form' => $form->createView(),
                'user' => $this->getUser(),
                'messages' => $message
            ));
        }
        else{
            return $this->render('CharlestownUserBundle:Profile:editCustomer.html.twig', array(
                'form' => $form->createView(),
                'user' => $this->getUser()
            ));
        }
    }

    /**
     * NIGGA GENPEPLU
     *
     * @Route("/submitAvatarNigga", name="upload_avatar", options={"expose"=true})
     * @Method("POST")
     */
    public function uploadAvatarAction(Request $request){
        $base = $request->get("base");


        $file = new File();
        $file->setAlt("png");
        $file->setName("avatar_collab.png");
        $file->setNameShow("avatar_collab.png");

        $this->getUser()->setPicture($file);

        $em = $this->getDoctrine()->getManager();
        $em->persist($file);
        $em->persist($this->getUser());
        $em->flush();

        $id = $file->getId();

        $filename_path = "files/".$id.".png";

        $base64_string = str_replace('data:image/png;base64,', '', $base);
        $base64_string = str_replace(' ', '+', $base64_string);
        $base64_string = base64_decode($base64_string);
        file_put_contents("uploads/".$filename_path,$base64_string);


        return new JsonResponse(array(
            "status" => "ok",
            "message" => "avatar uploaded"
        ));
    }
}
