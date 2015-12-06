<?php

namespace Charlestown\DemandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandFormation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\DemandBundle\Entity\DemandFormationRepository")
 */
class DemandFormation extends Demand
{
    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}

