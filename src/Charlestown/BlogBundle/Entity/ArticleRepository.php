<?php

namespace Charlestown\BlogBundle\Entity;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLasts(){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'Select a
                    From CharlestownBlogBundle:Article a
                    ');

        $result = $query->getResult();
        $lasts = array_slice($result,sizeof($result) - 15);

        return $lasts;
    }
}
