<?php

namespace Charlestown\DemandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandMobility
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\DemandBundle\Entity\DemandMobilityRepository")
 */
class DemandMobility extends Demand
{
    /**
     * @var \File
     *
     * @ORM\OneToOne(targetEntity="Charlestown\FileBundle\Entity\File", cascade={"persist"})
     */
    private $cV;


    /**
     * Set cV
     *
     * @param \File $cV
     *
     * @return DemandMobility
     */
    public function setCV($cV)
    {
        $this->cV = $cV;

        return $this;
    }

    /**
     * Get cV
     *
     * @return \File
     */
    public function getCV()
    {
        return $this->cV;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}

