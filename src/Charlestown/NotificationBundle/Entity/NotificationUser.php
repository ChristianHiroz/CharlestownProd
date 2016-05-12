<?php

namespace Charlestown\NotificationBundle\Entity;

use Charlestown\CollaboratorBundle\Entity\Collaborator;
use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\NotificationBundle\Entity\NotificationUserRepository")
 */
class NotificationUser
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
     * @ORM\Column(name="state", type="string", length=15)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="ordering", type="string", length=15, nullable=true)
     */
    private $order = null;

    /**
     * @var Collaborator
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="notification")
     */
    private $user;

    /**
     * @var Notification
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\NotificationBundle\Entity\Notification", inversedBy="user")
     */
    private $notification;


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
     * Set state
     *
     * @param string $state
     *
     * @return NotificationUser
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return NotificationUser
     */
    public function setUser($user)
    {
        $this->user = $user;
        $user->addNotification($this);

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
     * Set notification
     *
     * @param \stdClass $notification
     *
     * @return NotificationUser
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
        $notification->addUser($this);

        return $this;
    }

    /**
     * Get notification
     *
     * @return \stdClass
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
}

