<?php

namespace Charlestown\DemandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandMeeting
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\DemandBundle\Entity\DemandMeetingRepository")
 */
class DemandMeeting extends Demand
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="disponibility", type="string", length=255)
     */
    private $disponibility;

    /**
     * Set type
     *
     * @param string $type
     *
     * @return DemandMeeting
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set disponibility
     *
     * @param string $disponibility
     *
     * @return DemandMeeting
     */
    public function setDisponibility($disponibility)
    {
        $this->disponibility = $disponibility;

        return $this;
    }

    /**
     * Get disponibiilty
     *
     * @return string
     */
    public function getDisponibility()
    {
        return $this->disponibility;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}

