<?php

namespace Charlestown\DemandBundle\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Demand
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\DemandBundle\Entity\DemandRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"demand" = "Demand", "formation" = "Charlestown\DemandBundle\Entity\DemandFormation", "meeting" = "Charlestown\DemandBundle\Entity\DemandMeeting", "mobility" = "Charlestown\DemandBundle\Entity\DemandMobility", "meeting" = "Charlestown\DemandBundle\Entity\DemandMeeting", "vacancy" = "Charlestown\DemandBundle\Entity\DemandVacancy"})
 */
abstract class Demand
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
     * @ORM\Column(name="reason", type="string", length=255)
     */
    private $reason;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDemand", type="datetime")
     */
    private $dateDemand;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateResponse", type="datetime", nullable=true)
     */
    private $dateResponse;

    /**
     * @var boolean
     *
     * @ORM\Column(name="response", type="boolean", nullable=true)
     */
    private $response;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator")
     */
    private $user;

    public function __construct(){
        $this->dateDemand = new \DateTime();
    }

    /**
     * @return \User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * Set reason
     *
     * @param string $reason
     *
     * @return Demand
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set dateDemand
     *
     * @param \DateTime $dateDemand
     *
     * @return Demand
     */
    public function setDateDemand($dateDemand)
    {
        $this->dateDemand = $dateDemand;

        return $this;
    }

    /**
     * Get dateDemand
     *
     * @return \DateTime
     */
    public function getDateDemand()
    {
        return $this->dateDemand;
    }

    /**
     * Set dateResponse
     *
     * @param \DateTime $dateResponse
     *
     * @return Demand
     */
    public function setDateResponse($dateResponse)
    {
        $this->dateResponse = $dateResponse;

        return $this;
    }

    /**
     * Get dateResponse
     *
     * @return \DateTime
     */
    public function getDateResponse()
    {
        return $this->dateResponse;
    }

    /**
     * @return boolean
     */
    public function isResponse()
    {
        return $this->response;
    }

    /**
     * @param boolean $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }
    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Demand
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}

