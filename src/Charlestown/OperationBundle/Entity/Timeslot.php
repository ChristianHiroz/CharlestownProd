<?php

namespace Charlestown\OperationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Timeslot
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\OperationBundle\Entity\TimeslotRepository")
 */
class Timeslot
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
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var string
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var integer
     *
     * @ORM\Column(name="rooms", type="integer")
     */
    private $rooms;

    /**
     * @ORM\ManyToOne(targetEntity="Charlestown\OperationBundle\Entity\Operation", inversedBy="timeslots")
     */
    private $operation;

    /**
     * @var \OperationAppliance
     *
     * @ORM\OneToMany(targetEntity="Charlestown\OperationBundle\Entity\OperationAppliance", mappedBy="timeslot")
     */
    private $appliances;

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
     * Set start
     *
     * @param string $start
     *
     * @return Timeslot
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param string $end
     *
     * @return Timeslot
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
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
     * @return mixed
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param mixed $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
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
        if(!$this->operation){
            return $this->getStart()->format('d-m h:m'). '/' . $this->getEnd()->format('d-m h:m') . " (0/".$this->rooms.")";
        }
        $roomTaken = 0;
        if($this->operation->getAppliances()->isEmpty()) return $this->getStart()->format('d-m h:m'). '/' . $this->getEnd()->format('d-m h:m') . " (".$roomTaken."/".$this->rooms.")";
        foreach($this->operation->getAppliances() as $applicance){
            if($applicance->isAccepted()){
                $roomTaken++;
            }
        }
        return $this->getStart()->format('d-m h:m'). '/' . $this->getEnd()->format('d-m h:m') . " (".$roomTaken."/".$this->rooms.")";
    }
}

