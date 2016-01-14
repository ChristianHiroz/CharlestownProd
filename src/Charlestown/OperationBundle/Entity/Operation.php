<?php

namespace Charlestown\OperationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\OperationBundle\Entity\OperationRepository")
 */
class Operation
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * @var integer
     *
     * @ORM\Column(name="rooms", type="integer")
     */
    private $rooms;

    /**
     * @var string
     *
     * @ORM\Column(name="dayLength", type="string", length=255)
     */
    private $dayLength;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="mission", type="string", length=255)
     */
    private $mission;

    /**
     * @var string
     *
     * @ORM\Column(name="urlReport", type="string", length=255)
     */
    private $urlReport;

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CustomerBundle\Entity\Customer")
     */
    private $customer;

    /**
     * @var \Agency
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\AgencyBundle\Entity\Agency")
     */
    private $agency;

    /**
     * @var \File
     *
     * @ORM\OneToOne(targetEntity="Charlestown\FileBundle\Entity\File")
     */
    private $brief;

    /**
     * @var \OperationAppliance
     *
     * @ORM\OneToMany(targetEntity="Charlestown\OperationBundle\Entity\OperationAppliance", mappedBy="operation")
     */
    private $appliances;

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
     * Set type
     *
     * @param string $type
     *
     * @return Operation
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Operation
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return Operation
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
     * @return Operation
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

    /**
     * Set rooms
     *
     * @param integer $rooms
     *
     * @return Operation
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms
     *
     * @return integer
     */
    public function getRooms()
    {
       $room = $this->rooms;
        foreach($this->appliances as $appliance){
            if($appliance->isAccepted()){
                $room --;
            }
        }
        return $room;
    }

    /**
     * Set dayLength
     *
     * @param string $dayLength
     *
     * @return Operation
     */
    public function setDayLength($dayLength)
    {
        $this->dayLength = $dayLength;

        return $this;
    }

    /**
     * Get dayLength
     *
     * @return string
     */
    public function getDayLength()
    {
        return $this->dayLength;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return Operation
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set mission
     *
     * @param string $mission
     *
     * @return Operation
     */
    public function setMission($mission)
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * Get mission
     *
     * @return string
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set urlReport
     *
     * @param string $urlReport
     *
     * @return Operation
     */
    public function setUrlReport($urlReport)
    {
        $this->urlReport = $urlReport;

        return $this;
    }

    /**
     * Get urlReport
     *
     * @return string
     */
    public function getUrlReport()
    {
        return $this->urlReport;
    }

    /**
     * Set customer
     *
     * @param \stdClass $customer
     *
     * @return Operation
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \stdClass
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set agency
     *
     * @param \stdClass $agency
     *
     * @return Operation
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \stdClass
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Set brief
     *
     * @param \stdClass $brief
     *
     * @return Operation
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * Get brief
     *
     * @return \stdClass
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Set appliances
     *
     * @param \stdClass $appliances
     *
     * @return Operation
     */
    public function setAppliances($appliances)
    {
        $this->appliances = $appliances;

        return $this;
    }

    /**
     * Get appliances
     *
     * @return \stdClass
     */
    public function getAppliances()
    {
        return $this->appliances;
    }

    public function addAppliance(OperationAppliance $appliance){
        $this->appliances[] = $appliance;
    }

    public function removeAppliance(OperationAppliance $appliance){
        $this->appliances->removeElement($appliance);
    }

    public function __toString(){
        return $this->customer->getCompanyName().$this->getId();
    }
}

