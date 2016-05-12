<?php

namespace Charlestown\NotificationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\NotificationBundle\Entity\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="notifiedAt", type="datetime")
     */
    private $notifiedAt;

    /**
     * @var NotificationUser
     *
     * @ORM\OneToMany(targetEntity="Charlestown\NotificationBundle\Entity\NotificationUser", mappedBy="notification")
     */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="relativeId", type="integer")
     */
    private $relativeId;

    public function __construct(){
        $this->user = new ArrayCollection();
        $this->notifiedAt = new \DateTime();
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
     * Set title
     *
     * @param string $title
     *
     * @return Notification
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Notification
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set notifiedAt
     *
     * @param \DateTime $notifiedAt
     *
     * @return Notification
     */
    public function setNotifiedAt($notifiedAt)
    {
        $this->notifiedAt = $notifiedAt;

        return $this;
    }

    /**
     * Get notifiedAt
     *
     * @return \DateTime
     */
    public function getNotifiedAt()
    {
        return $this->notifiedAt;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return Notification
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Notification
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
     * @return NotificationUser
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param NotificationUser $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @param NotificationUser $user
     */
    public function addUser($user){
        $this->users[] = $user;
    }

    /**
     * @return int
     */
    public function getRelativeId()
    {
        return $this->relativeId;
    }

    /**
     * @param int $relativeId
     */
    public function setRelativeId($relativeId)
    {
        $this->relativeId = $relativeId;
    }
    }

