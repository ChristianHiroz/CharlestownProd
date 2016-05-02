<?php
namespace Charlestown\DemandBundle\Listeners;

use Charlestown\DemandBundle\Entity\Demand;
use Charlestown\OperationBundle\Entity\OperationAppliance;
use Doctrine\ORM\Event\LifecycleEventArgs;

class DemandNotification
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function postUpdate(LifecycleEventArgs $args) //Mails RC, désactivés
    {
//        $entity = $args->getEntity();
//        if ($entity instanceof Demand) {
//            $this->container->get('charlestown.mailer')->sendDemandResponseMail($entity);
//        }
//
//
//        if($entity instanceof OperationAppliance)
//        {
//            $this->container->get('charlestown.mailer')->sendOperationApplianceResponseMail($entity);
//        }

        return;
    }

}