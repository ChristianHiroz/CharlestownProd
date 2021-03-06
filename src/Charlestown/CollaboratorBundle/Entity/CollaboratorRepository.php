<?php

namespace Charlestown\CollaboratorBundle\Entity;

use Charlestown\CustomerBundle\Entity\Customer;

/**
 * CollaboratorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CollaboratorRepository extends \Doctrine\ORM\EntityRepository
{
    public function findSyndicated(){
        $empty = "";
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'Select c
                    From CharlestownCollaboratorBundle:Collaborator c
                    WHERE c.syndicat != ?1 ');

        $query->setParameter(1,$empty);

        return $query->getResult();
    }

    public function findBySite(Customer $customer){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'Select c
                    From CharlestownCollaboratorBundle:Collaborator c
                    WHERE c.customer = ?1 ');

        $query->setParameter(1,$customer);

        return $query->getResult();
    }
}
