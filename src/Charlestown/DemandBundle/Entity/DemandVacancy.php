<?php

namespace Charlestown\DemandBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandVacancy
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\DemandBundle\Entity\DemandVacancyRepository")
 */
class DemandVacancy extends Demand
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime")
     */
    private $dateEnd;


    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return DemandVacancy
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return DemandVacancy
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}

