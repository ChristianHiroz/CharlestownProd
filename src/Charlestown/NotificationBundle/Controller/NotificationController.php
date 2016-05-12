<?php

namespace Charlestown\NotificationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends Controller
{

    /**
     * Return all Notification entity that are new
     *
     * @Route("/reloadNotification/{id}", name="message_reload", options={"expose"=true})
     * @Method("GET")
     */
    public function reloadNotificationAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $notifications = $user->getNotifications();

        $returnArray = array();

        foreach($notifications as $notification){
            $returnArray[] = $this->notificationToJson($notification);
        }

        return new JsonResponse($returnArray);

    }

    /**
     * Delete a notification for one user
     *
     * @Route("/deleteNotification/{id}", name="notification_delete", options={"expose"=true})
     * @Method("GET")
     */
    public function deleteNotificationAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $notification = $em->getRepository("CharlestownNotificationBundle:NotificationUser")->find($id);

        $em->remove($notification);
        $em->flush();

        $returnArray = array("status" => "ok", "message" => "notification deleted");

        return new JsonResponse($returnArray);

    }

    /**
     * Delete a notification for one user and force others to do it
     *
     * @Route("/readNotification/{id}", name="notification_read", options={"expose"=true})
     * @Method("GET")
     */
    public function readNotificationAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $notification = $em->getRepository("CharlestownNotificationBundle:NotificationUser")->find($id);
        $notifications = $notification->getNotification()->getUsers();


        foreach($notifications as $notif){
            $notif->setOrder("TODO");
            $em->persist($notif);
        }

        $em->remove($notification);
        $em->flush();


        $returnArray = array("status" => "ok", "message" => "notification deleted");

        return new JsonResponse($returnArray);

    }

    /**
     * Delete a notification for one user and transform it to info for others in order to tell that its done
     *
     * @Route("/completeNotification/{id}", name="notification_complete", options={"expose"=true})
     * @Method("GET")
     */
    public function completeNotificationAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $notification = $em->getRepository("CharlestownNotificationBundle:NotificationUser")->find($id);
        $notifications = $notification->getNotification()->getUsers();


        foreach($notifications as $notif){
            $notif->setState("info");
            $em->persist($notif);
        }

        $em->remove($notification);
        $em->flush();


        $returnArray = array("status" => "ok", "message" => "notification deleted");

        return new JsonResponse($returnArray);

    }

    private function notificationToJson($notification){
        return array(
            "state" => $notification->getState(),
            "title" => $notification->getNotification()->getTitle(),
            "description" => $notification->getNotification()->getDescription(),
            "notifiedAt" => $notification->getNotification()->getNotifiedAt(),
            "type" => $notification->getNotification()->getType()
        );
    }
}
