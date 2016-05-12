<?php
namespace Charlestown\DemandBundle\Listeners;

use Charlestown\CustomerBundle\Entity\Devis;
use Charlestown\DemandBundle\Entity\Demand;
use Charlestown\DemandBundle\Entity\DemandFormation;
use Charlestown\DemandBundle\Entity\DemandMeeting;
use Charlestown\DemandBundle\Entity\DemandMobility;
use Charlestown\NotificationBundle\Entity\NotificationUser;
use Charlestown\OperationBundle\Entity\FileOperation;
use Charlestown\OperationBundle\Entity\Operation;
use Charlestown\OperationBundle\Entity\OperationAppliance;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Charlestown\NotificationBundle\Entity\Notification;

class DemandNotification
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $args){

        $em = $this->container->get('doctrine')->getManager();
        $entity = $args->getEntity();
        if ($entity instanceof Demand) {
            $notification = new Notification();
            $rcNotification = new NotificationUser();
            $plNotification = new NotificationUser();
            $twNotification = new NotificationUser();

            if($entity instanceof DemandMeeting)
            {
                $type = "rendez-vous";
                $notification->setType("DemandMeeting");
            }
            elseif($entity instanceof DemandMobility){
                $type = "mobilité";
                $notification->setType("DemandMobility");
            }
            elseif($entity instanceof DemandFormation){
                $type = "formation";
                $notification->setType("DemandFormation");
            }
            else{
                $type = "congés";
                $notification->setType("DemandVacancy");
            }
            $notification->setTitle("Nouvelle demande de " . $type . " par " . $entity->getUser()->getFirstName() . " " .$entity->getUser()->getLastName());
            $notification->setDescription("Cette demande a été éffectuée le " . $entity->getDateDemand()->format('d/m/Y') . ", voici son détail: " . $entity->getComment());
            $notification->setRelativeId($entity->getId());

            $agency = $entity->getUser()->getAgency();
            $rcNotification->setNotification($notification);
            $plNotification->setNotification($notification);
            $twNotification->setNotification($notification);

            $rcNotification->setUser($agency->getCustomerManager());
            $plNotification->setUser($agency->getPlanningCoordinator());
            $twNotification->setUser($agency->getThirdWellAccount());

            $rcNotification->setState("unread");
            $plNotification->setState("unread");
            $twNotification->setState("unread");

            $em->persist($notification);
            $em->persist($rcNotification);
            $em->persist($plNotification);
            $em->persist($twNotification);

            $em->flush();
        }
        if ($entity instanceof Devis) {
            $notification = new Notification();
            $rcNotification = new NotificationUser();
            $plNotification = new NotificationUser();
            $twNotification = new NotificationUser();

            $notification->setType("Devis");
            $notification->setTitle("Nouvelle demande de devis par " . $entity->getCustomer()->getCompanyName());
            $notification->setDescription("Type de prestation: " . $entity->getPrestationType() . " pour " . $entity->getNbHote()  . " personnes" );
            $notification->setRelativeId($entity->getId());

            $agency = $entity->getCustomer()->getAgency();
            $rcNotification->setNotification($notification);
            $plNotification->setNotification($notification);
            $twNotification->setNotification($notification);

            $rcNotification->setUser($agency->getCustomerManager());
            $plNotification->setUser($agency->getPlanningCoordinator());
            $twNotification->setUser($agency->getThirdWellAccount());

            $rcNotification->setState("unread");
            $plNotification->setState("unread");
            $twNotification->setState("unread");

            $em->persist($notification);
            $em->persist($rcNotification);
            $em->persist($plNotification);
            $em->persist($twNotification);

            $em->flush();
        }
        if ($entity instanceof OperationAppliance){
            $notification = new Notification();
            $rcNotification = new NotificationUser();
            $plNotification = new NotificationUser();
            $twNotification = new NotificationUser();

            $notification->setType("OperationAppliance");
            $notification->setTitle("Nouvelle candidature de " . $entity->getEvent()->getFirstName() . " " .$entity->getEvent()->getLastName());
            $notification->setDescription("Cette candidature a été éffectuée le " . $entity->getDate()->format('d/m/Y') . ", à l'opération : " . $entity->getOperation()->getName());
            $notification->setRelativeId($entity->getId());

            $agency = $entity->getEvent()->getAgency();
            $rcNotification->setNotification($notification);
            $plNotification->setNotification($notification);
            $twNotification->setNotification($notification);

            $rcNotification->setUser($agency->getCustomerManager());
            $plNotification->setUser($agency->getPlanningCoordinator());
            $twNotification->setUser($agency->getThirdWellAccount());

            $rcNotification->setState("unread");
            $plNotification->setState("unread");
            $twNotification->setState("unread");

            $em->persist($notification);
            $em->persist($rcNotification);
            $em->persist($plNotification);
            $em->persist($twNotification);

            $em->flush();
        }
        if ($entity instanceof FileOperation){
            $notification = new Notification();
            $rcNotification = new NotificationUser();
            $plNotification = new NotificationUser();
            $twNotification = new NotificationUser();

            $notification->setType("FileOperation");
            $notification->setTitle("Nouvelle photo de " . $entity->getEvent()->getFirstName() . " " .$entity->getEvent()->getLastName());
            $notification->setDescription("Cette photo a été postée le " . $entity->getDate()->format('d/m/Y') . ", pour l'opération : " . $entity->getOperation()->getName());
            $notification->setRelativeId($entity->getId());

            $agency = $entity->getEvent()->getAgency();
            $rcNotification->setNotification($notification);
            $plNotification->setNotification($notification);
            $twNotification->setNotification($notification);

            $rcNotification->setUser($agency->getCustomerManager());
            $plNotification->setUser($agency->getPlanningCoordinator());
            $twNotification->setUser($agency->getThirdWellAccount());

            $rcNotification->setState("unread");
            $plNotification->setState("unread");
            $twNotification->setState("unread");

            $em->persist($notification);
            $em->persist($rcNotification);
            $em->persist($plNotification);
            $em->persist($twNotification);

            $em->flush();
        }
    }

    public function postUpdate(LifecycleEventArgs $args) //Mails RC, désactivés
    {
        $entity = $args->getEntity();
        if ($entity instanceof Demand) {
//            $this->container->get('charlestown.mailer')->sendDemandResponseMail($entity); // Mail notification RC désactivé
        }

//
//        if($entity instanceof OperationAppliance)
//        {
//            $this->container->get('charlestown.mailer')->sendOperationApplianceResponseMail($entity);
//        }

        return;
    }

}