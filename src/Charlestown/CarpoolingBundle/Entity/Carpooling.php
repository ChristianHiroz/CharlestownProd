<?php

namespace Charlestown\CarpoolingBundle\Entity;

use Charlestown\CollaboratorBundle\Entity\Collaborator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Carpooling
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\CarpoolingBundle\Entity\CarpoolingRepository")
 */
class Carpooling
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTravel", type="datetime")
     */
    private $dateTravel;

    /**
     * @var integer
     *
     * @ORM\Column(name="room", type="integer")
     */
    private $room;

    /**
     * @var string
     *
     * @ORM\Column(name="startPlace", type="string", length=255)
     */
    private $startPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="endPlace", type="string", length=255)
     */
    private $endPlace;

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="myCarpoolings")
     */
    private $driver;

    /**
     * @var \Customer
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="myCarpoolingsApplication")
     * @ORM\JoinTable(name="carpooling_application")
     */
    private $applicants;

    /**
     * @var \Customer
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="myCarpoolingsSelection")
     * @ORM\JoinTable(name="carpooling_selection")
     */
    private $selected;

    public function __construct(){
        $this->applicants = new ArrayCollection();
        $this->selected = new ArrayCollection();
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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Carpooling
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateTravel
     *
     * @param \DateTime $dateTravel
     *
     * @return Carpooling
     */
    public function setDateTravel($dateTravel)
    {
        $this->dateTravel = $dateTravel;

        return $this;
    }

    /**
     * Get dateTravel
     *
     * @return \DateTime
     */
    public function getDateTravel()
    {
        return $this->dateTravel;
    }

    /**
     * Set room
     *
     * @param integer $room
     *
     * @return Carpooling
     */
    public function setRoom($room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return integer
     */
    public function getRoom()
    {
        $room = $this->room - $this->selected->count();
        return $room;
    }

    /**
     * Set startPlace
     *
     * @param string $startPlace
     *
     * @return Carpooling
     */
    public function setStartPlace($startPlace)
    {
        $this->startPlace = $startPlace;

        return $this;
    }

    /**
     * Get startPlace
     *
     * @return string
     */
    public function getStartPlace()
    {
        return $this->startPlace;
    }

    /**
     * Set endPlace
     *
     * @param string $endPlace
     *
     * @return Carpooling
     */
    public function setEndPlace($endPlace)
    {
        $this->endPlace = $endPlace;

        return $this;
    }

    /**
     * Get endPlace
     *
     * @return string
     */
    public function getEndPlace()
    {
        return $this->endPlace;
    }

    /**
     * Set driver
     *
     * @param Collaborator $driver
     *
     * @return Carpooling
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get driver
     *
     * @return Collaborator
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set applicants
     *
     * @param \ArayCollection $applicants
     *
     * @return Carpooling
     */
    public function setApplicants($applicants)
    {
        $this->applicants = $applicants;

        return $this;
    }

    /**
     * Get applicants
     *
     * @return \ArayCollection
     */
    public function getApplicants()
    {
        return $this->applicants;
    }

    /**
     * Set selected
     *
     * @param \ArayCollection $selected
     *
     * @return Carpooling
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * Get selected
     *
     * @return \ArayCollection
     */
    public function getSelected()
    {
        return $this->selected;
    }

    public function addSelected(Collaborator $selected){
        $this->selected[] = $selected;
    }

    public function addApplicant(Collaborator $applicant){
        $this->applicants[] = $applicant;
    }

    public function removeApplicant(Collaborator $applicant){
        $this->applicants->removeElement($applicant);
    }

    public function removeSelected(Collaborator $selected){
        $this->selected->removeElement($selected);
    }
}

