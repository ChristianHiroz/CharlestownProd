<?php

namespace Charlestown\OperationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

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
     * @var string
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CustomerBundle\Entity\Customer", inversedBy="operations")
     */
    private $customer;

    /**
     * @var \File_operation
     *
     * @ORM\OneToMany(targetEntity="Charlestown\OperationBundle\Entity\FileOperation", mappedBy="operation")
     */
    private $files;

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

    /**
     * @var \Timeslot
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\OperationBundle\Entity\Timeslot")
     */
    private $timeslots;

    public function __construct(){
        $this->date = new \DateTime();
        $this->active = true;
        $this->timeslots = new ArrayCollection();
        $this->appliances = new ArrayCollection();
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param string $active
     */
    public function setActive($active)
    {
        $this->active = $active;
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
        return $this->rooms;
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

    public function getTimeslots(){
        return $this->timeslots;
    }

    public function addTimeslot(Timeslot $timeslot){
        $this->timeslots[] = $timeslot;
    }

    public function setTimeslots($timeslots){
        $this->timeslots = $timeslots;
    }

    /**
     * @return \File_operation
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param \File_operation $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }


    public function __toString(){
        $roomTaken = 0;
        if($this->appliances->isEmpty()) return $this->name . " (".$roomTaken."/".$this->rooms.")";
        foreach($this->appliances as $applicance){
            if($applicance->isAccepted()){
                $roomTaken++;
            }
        }
        return $this->name . " (".$roomTaken."/".$this->rooms.")";
    }
}

