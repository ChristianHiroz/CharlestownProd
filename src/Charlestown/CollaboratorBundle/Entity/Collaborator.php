<?php

namespace Charlestown\CollaboratorBundle\Entity;

use Charlestown\CarpoolingBundle\Entity\Carpooling;
use Charlestown\CustomerBundle\Entity\Customer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Charlestown\UserBundle\Entity\User as User;

/**
 * Collaborator
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\CollaboratorBundle\Entity\CollaboratorRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"collaborator" = "Collaborator", "businessSupport" = "BusinessSupport", "event" = "Event"})
 */
abstract class Collaborator extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string")
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string")
     */
    private $position;

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CustomerBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=true)
     */
    private $customer;

    /**
     * @var \Customer
     *
     * @ORM\OneToMany(targetEntity="Charlestown\CarpoolingBundle\Entity\Carpooling", mappedBy="driver")
     */
    private $myCarpoolings;

    /**
     * @var \Customer
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\CarpoolingBundle\Entity\Carpooling", mappedBy="applicants")
     */
    private $myCarpoolingsApplication;

    /**
     * @var \Customer
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\CarpoolingBundle\Entity\Carpooling", mappedBy="selected")
     */
    private $myCarpoolingsSelection;

    public function __construct()
    {
        $this->myCarpoolings = new ArrayCollection();
        $this->myCarpoolingsApplication = new ArrayCollection();
        $this->myCarpoolingsSelection = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Customer
     */
    public function getCustomer(){
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer = null){
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return ArrayCollection
     */
    public function getMyCarpoolings()
    {
        return $this->myCarpoolings;
    }

    /**
     * @param ArrayCollection $myCarpoolings
     */
    public function setMyCarpoolings($myCarpoolings)
    {
        $this->myCarpoolings = $myCarpoolings;
    }

    /**
     * @return ArrayCollection
     */
    public function getMyCarpoolingsApplication()
    {
        return $this->myCarpoolingsApplication;
    }

    /**
     * @param ArrayCollection $myCarpoolingsApplication
     */
    public function setMyCarpoolingsApplication($myCarpoolingsApplication)
    {
        $this->myCarpoolingsApplication = $myCarpoolingsApplication;
    }

    /**
     * @return ArrayCollection
     */
    public function getMyCarpoolingsSelection()
    {
        return $this->myCarpoolingsSelection;
    }

    /**
     * @param ArrayCollection $myCarpoolingsSelection
     */
    public function setMyCarpoolingsSelection($myCarpoolingsSelection)
    {
        $this->myCarpoolingsSelection = $myCarpoolingsSelection;
    }

    /**
     * @param Carpooling $carpooling
     */
    public function addMyCarpooling(Carpooling $carpooling){
        $this->myCarpoolings[] = $carpooling;
    }

    /**
     * @param Carpooling $carpooling
     */
    public function addMyCarpoolingApplication(Carpooling $carpooling){
        $this->myCarpoolings[] = $carpooling;
    }

    /**
     * @param Carpooling $carpooling
     */
    public function addMyCarpoolingSelection(Carpooling $carpooling){
        $this->myCarpoolings[] = $carpooling;
    }


}

