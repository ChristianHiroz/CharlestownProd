<?php

namespace Charlestown\AnnouncmentBundle\Entity;

/**
 * AnnouncmentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnnouncmentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLasts()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'Select a
                    From CharlestownAnnouncmentBundle:Announcment a
                    Where a.visible = TRUE
                    '
        );

        $result = $query->getResult();
        if (sizeof($result) > 12) {
            $lasts = array_slice($result, sizeof($result) - 12);

            return $lasts;
        }

        return $result;
    }


        public function search($type, $name, $town){
            $em = $this->getEntityManager();
            if($name == ""){
                $query = $em->createQuery(
                    'Select a
                    From CharlestownAnnouncmentBundle:Announcment a
                    JOIN a.offerer o
                    JOIN o.agency ag
                    Where a.visible = TRUE
                    AND a.type = ?1
                    AND ag.localisation = ?2

                    ');
                $query->setParameter(1, $type);
                $query->setParameter(2, $town);
            }
            else{
                $query = $em->createQuery(
                    'Select a
                    From CharlestownAnnouncmentBundle:Announcment a
                    JOIN a.offerer o
                    JOIN o.agency ag
                    Where a.visible = TRUE
                    AND a.type = ?1
                    AND a.title LIKE ?2
                    AND ag.localisation = ?3

                    ');
                $query->setParameter(1, $type);
                $query->setParameter(2, $name);
                $query->setParameter(3, $town);
            }

            $result = $query->getResult();

            return $result;
        }
}
