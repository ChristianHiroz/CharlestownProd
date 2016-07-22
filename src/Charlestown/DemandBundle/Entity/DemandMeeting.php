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
     * @ORM\Column(name="disponibility", type="string", length=255)
     */
    private $disponibility;

    /**
     * @var string
     *
     * @ORM\Column(name="fixedDate", type="datetime", nullable=true)
     */
    private $fixedDate;

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

    /**
     * @return string
     */
    public function getFixedDate()
    {
        return $this->fixedDate;
    }

    /**
     * @param string $fixedDate
     */
    public function setFixedDate($fixedDate)
    {
        $this->fixedDate = $fixedDate;
    }


    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    public function __toString(){
        return "rendez-vous";
    }
}

