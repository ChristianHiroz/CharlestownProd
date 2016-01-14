<?php

namespace Charlestown\OperationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperationAppliance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\OperationBundle\Entity\OperationApplianceRepository")
 */
class OperationAppliance
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Event", inversedBy="appliances", cascade={"persist"})
     */
    private $event;

    /**
     * @var \Operation
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\OperationBundle\Entity\Operation", inversedBy="appliances", cascade={"persist"})
     */
    private $operation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accepted", type="boolean")
     */
    private $accepted = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateResp", type="datetime", nullable=true)
     */
    private $dateResp;

    public function __construct(){
        $this->date = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set event
     *
     * @param \stdClass $event
     *
     * @return OperationAppliance
     */
    public function setEvent($event)
    {
        $this->event = $event;
        $event->addAppliance($this);

        return $this;
    }

    /**
     * Get event
     *
     * @return \stdClass
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set operation
     *
     * @param \stdClass $operation
     *
     * @return OperationAppliance
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
        $operation->addAppliance($this);

        return $this;
    }

    /**
     * Get operation
     *
     * @return \stdClass
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return OperationAppliance
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
        $this->dateResp = new \DateTime();

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean
     */
    public function isAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return OperationAppliance
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dateResp
     *
     * @param \DateTime $dateResp
     *
     * @return OperationAppliance
     */
    public function setDateResp($dateResp)
    {
        $this->dateResp = $dateResp;

        return $this;
    }

    /**
     * Get dateResp
     *
     * @return \DateTime
     */
    public function getDateResp()
    {
        return $this->dateResp;
    }
}

