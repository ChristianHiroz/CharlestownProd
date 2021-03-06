<?php

namespace Charlestown\ChatBundle\Controller;

use Charlestown\ChatBundle\Entity\Chatroom;
use Charlestown\ChatBundle\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ChatController extends Controller
{

    /**
     * @Route("/chat", name="social_chat_collaborator")
     * @Template()
     */
    public function indexAction()
    {
        if($this->getUser() == null) {
            return $this->redirect($this->generateUrl('index'));
        }
        elseif($this->getUser()->hasRole("ROLE_CUSTOMER")){
            return $this->redirect($this->generateUrl('index'));
        }
        elseif($this->getUser()->hasRole("ROLE_USER")){
            $messages = $this->getDoctrine()->getManager()->getRepository('CharlestownChatBundle:Message')->findAll();

            return array('user' => $this->getUser(), 'messages' => $messages);
        }
        else return $this->redirect($this->generateUrl('index'));
    }


    /**
     * Create a Message entity and add it to his chatroom
     *
     * @Route("/createMessage", name="message_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createMessageAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $messageText = $request->get('message');

        $message = new Message();
        $message->setWriter($this->getUser());
        $message->setMessage($messageText);

        $em->persist($message);
        $em->flush();

        return new JsonResponse(array(
            'status' => 'ok',
            'message' => 'Message created',
        ));

    }

    /**
     * Create a Message entity and add it to his chatroom
     *
     * @Route("/createMessageTest", name="message_create_test", options={"expose"=true})
     * @Method("POST")
     */
    public function createMessageTestAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $messageText = $request->get('message');

        $writer = $em->getRepository('CharlestownCollaboratorBundle:Collaborator')->find(15);

        $message = new Message();
        $message->setWriter($writer);
        $message->setMessage($messageText);

        $em->persist($message);
        $em->flush();


        return new JsonResponse(array(
            'status' => 'ok',
            'message' => 'Message created',
        ));

    }

    /**
     * Return all Message entity that are new
     *
     * @Route("/reloadMessage/{id}", name="message_reload", options={"expose"=true})
     * @Method("GET")
     */
    public function reloadMessageAction($id){
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('CharlestownChatBundle:Message')->findLastMessages($id);
        $returnArray = array();

        foreach($messages as $message){
            $returnArray[] = $this->messageToJson($message);
        }


        return new JsonResponse($returnArray);

    }


    public function messageToJson(Message $message){
        $notmine = true;
        if($message->getWriter() == $this->getUser()){
            $notmine = false;
        }
        if($message->getWriter()->getPicture()){
            $pictureid = $message->getWriter()->getPicture()->getId();
            $picturealt = $message->getWriter()->getPicture()->getAlt();
        }
        else{
            $picturealt = "";
            $pictureid = 0;
        }
        return array(
            "id" => $message->getId(),
            "message" => $message->getMessage(),
            "writedAt" => $message->getWritedAt(),
            "writer" => $message->getWriter()->getId(),
            "pictureid" => $pictureid,
            "picturealt" => $picturealt,
            "notmine" => $notmine,
        );
    }
}
