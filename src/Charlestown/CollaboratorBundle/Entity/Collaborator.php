<?php

namespace Charlestown\CollaboratorBundle\Entity;

use Charlestown\CarpoolingBundle\Entity\Carpooling;
use Charlestown\ChatBundle\Entity\Chatroom;
use Charlestown\CustomerBundle\Entity\Customer;
use Charlestown\FileBundle\Entity\File;
use Charlestown\NotificationBundle\Entity\NotificationUser;
use Charlestown\OperationBundle\Entity\OperationAppliance;
use Charlestown\SkillPurseBundle\Entity\Lesson;
use Charlestown\SkillPurseBundle\Entity\Skill;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Charlestown\UserBundle\Entity\User as User;


/**
 * Collaborator
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\CollaboratorBundle\Entity\CollaboratorRepository")
 */
class Collaborator extends User
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
     * @ORM\Column(name="portPhoneNumber", type="string", nullable=true)
     */
    private $portPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="birthDate", type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CustomerBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=true)
     */
    private $customer;

    /**
     * @var boolean
     *
     * @ORM\Column(name="swapable", type="boolean")
     */
    private $swapable = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activeChat", type="boolean")
     */
    private $activeChat = true;

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


    /**
     * @var \Lessons
     *
     * @ORM\OneToMany(targetEntity="Charlestown\SkillPurseBundle\Entity\Lesson", mappedBy="teacher")
     */
    private $myLessons;

    /**
     * @var \Lessons
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\SkillPurseBundle\Entity\Lesson", mappedBy="studentsApplicants")
     */
    private $myLessonsApplication;

    /**
     * @var \Lessons
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\SkillPurseBundle\Entity\Lesson", mappedBy="students")
     */
    private $lessons;

    /**
     * @var \Syndicat
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Syndicat")
     * @ORM\JoinColumn(name="syndicat_id", referencedColumnName="id", nullable=true)
     */
    private $syndicat;

    /**
     * @var \Mandate
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\CollaboratorBundle\Entity\Mandate")
     *@ORM\JoinTable(name="user_mandates",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id",nullable=true)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="mandate_id", referencedColumnName="id",nullable=true)})
     */
    private $mandates;


    /**
     * @var \OperationAppliance
     *
     * @ORM\OneToMany(targetEntity="Charlestown\OperationBundle\Entity\OperationAppliance", mappedBy="event")
     */
    private $appliances;


    /**
     * @var \Announcment
     *
     * @ORM\OneToMany(targetEntity="Charlestown\AnnouncmentBundle\Entity\Announcment", mappedBy="offerer")
     */
    private $myOffers;


    /**
     * @var \Announcment
     *
     * @ORM\OneToMany(targetEntity="Charlestown\AnnouncmentBundle\Entity\Announcment", mappedBy="applicant")
     */
    private $myOffersApplications;


    /**
     * @var \Files
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     */
    private $evaluations;

    /**
     * @var NotificationUser
     *
     * @ORM\OneToMany(targetEntity="Charlestown\NotificationBundle\Entity\NotificationUser", mappedBy="user")
     */
    private $notifications;


    public function __construct()
    {
        $this->myCarpoolings = new ArrayCollection();
        $this->myCarpoolingsApplication = new ArrayCollection();
        $this->myCarpoolingsSelection = new ArrayCollection();
        $this->myLessons = new ArrayCollection();
        $this->myLessonsApplication = new ArrayCollection();
        $this->lessons = new ArrayCollection();
        $this->mandates = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->appliances = new ArrayCollection();
        $this->myOffers = new ArrayCollection();
        $this->myOffersApplications = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->activeChat = true;
        $this->addRole("ROLE_USER");
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

    public function addMyLesson(Lesson $lesson){
        $this->myLessons[] = $lesson;
    }

    public function addLesson(Lesson $lesson){
        $this->myLessons[] = $lesson;
    }

    public function addLessonApplication(Lesson $lesson){
        $this->myLessonsApplication[] = $lesson;
    }

    /**
     * @return \Lessons
     */
    public function getMyLessons()
    {
        return $this->myLessons;
    }

    /**
     * @param \Lessons $myLessons
     */
    public function setMyLessons($myLessons)
    {
        $this->myLessons = $myLessons;
    }

    /**
     * @return \Customer
     */
    public function getMyLessonsApplication()
    {
        return $this->myLessonsApplication;
    }

    /**
     * @param \Customer $myLessonsApplication
     */
    public function setMyLessonsApplication($myLessonsApplication)
    {
        $this->myLessonsApplication = $myLessonsApplication;
    }

    /**
     * @return \Customer
     */
    public function getLessons()
    {
        return $this->lessons;
    }

    /**
     * @param \Customer $lessons
     */
    public function setLessons($lessons)
    {
        $this->lessons = $lessons;
    }

    /**
     * @return \Syndicat
     */
    public function getSyndicat()
    {
        return $this->syndicat;
    }

    /**
     * @param \Syndicat $syndicat
     */
    public function setSyndicat($syndicat)
    {
        $this->syndicat = $syndicat;
    }

    /**
     * @return \Mandate
     */
    public function getMandates()
    {
        return $this->mandates;
    }

    /**
     * @param \Mandate $mandates
     */
    public function setMandates($mandates)
    {
        $this->mandates = $mandates;
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

    /**
     * @return \Announcment
     */
    public function getMyOffers()
    {
        return $this->myOffers;
    }

    /**
     * @param \Announcment $myOffers
     */
    public function setMyOffers($myOffers)
    {
        $this->myOffers = $myOffers;
    }

    public function addOffer($offer)
    {
        $this->myOffers[] = $offer;
    }

    /**
     * @return \Announcment
     */
    public function getMyOffersApplications()
    {
        return $this->myOffersApplications;
    }

    /**
     * @param \Announcment $myOffersApplications
     */
    public function setMyOffersApplications($myOffersApplications)
    {
        $this->myOffersApplications = $myOffersApplications;
    }

    public function addOfferApplication($offer)
    {
        $this->myOffersApplications[] = $offer;
    }



    /**
     * @return \Files
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * @param \Files $evaluations
     */
    public function setEvaluations($evaluations)
    {
        $this->evaluations = $evaluations;
    }

    /**
     * @param File $evaluation
     */
    public function addEvaluation(File $evaluation)
    {
        $this->evaluations[] = $evaluation;
    }

    /**
     * @return boolean
     */
    public function isSwapable()
    {
        return $this->swapable;
    }

    /**
     * @param boolean $swapable
     */
    public function setSwapable($swapable)
    {
        $this->swapable = $swapable;
    }

    /**
     * @return boolean
     */
    public function isActiveChat()
    {
        return $this->activeChat;
    }

    /**
     * @param boolean $activeChat
     */
    public function setActiveChat($activeChat)
    {
        $this->activeChat = $activeChat;
    }

    /**
     * @return NotificationUser
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param NotificationUser $notification
     */
    public function addNotification($notification)
    {
        $this->notifications[] = $notification;
    }

    /**
     * @return string
     */
    public function getPortPhoneNumber()
    {
        return $this->portPhoneNumber;
    }

    /**
     * @param string $portPhoneNumber
     */
    public function setPortPhoneNumber($portPhoneNumber)
    {
        $this->portPhoneNumber = $portPhoneNumber;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }
}

