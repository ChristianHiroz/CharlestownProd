<?php

namespace Charlestown\AgencyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agency
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\AgencyBundle\Entity\AgencyRepository")
 */
class Agency
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
     * @ORM\Column(name="localisation", type="string", length=50)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_urgence", type="string", length=10)
     */
    private $numeroUrgence;

    /**
     * @var \BusinessSupport
     *
     * @ORM\OneToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\BusinessSupport")
     */
    private $customerManager;

    /**
     * @var \Event
     *
     * @ORM\OneToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Event")
     */
    private $eventCustomerManager;

    /**
     * @var \Collaborator
     *
     * @ORM\OneToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\BusinessSupport")
     */
    private $planningCoordinator;


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
     * Set localisation
     *
     * @param string $localisation
     *
     * @return Agency
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
     * Set customerManager
     *
     * @param \BusinnessSupport $customerManager
     *
     * @return Agency
     */
    public function setCustomerManager($customerManager)
    {
        $this->customerManager = $customerManager;

        return $this;
    }

    /**
     * Get customerManager
     *
     * @return \BusinnessSupport
     */
    public function getCustomerManager()
    {
        return $this->customerManager;
    }

    /**
     * Set eventCustomerManager
     *
     * @param \Event $eventCustomerManager
     *
     * @return Agency
     */
    public function setEventCustomerManager($eventCustomerManager)
    {
        $this->eventCustomerManager = $eventCustomerManager;

        return $this;
    }

    /**
     * Get eventCustomerManager
     *
     * @return \Event
     */
    public function getEventCustomerManager()
    {
        return $this->eventCustomerManager;
    }

    /**
     * Set planningCoordinator
     *
     * @param \BusinessSupport $planningCoordinator
     *
     * @return Agency
     */
    public function setPlanningCoordinator($planningCoordinator)
    {
        $this->planningCoordinator = $planningCoordinator;

        return $this;
    }

    /**
     * Get planningCoordinator
     *
     * @return \BusinessSupport
     */
    public function getPlanningCoordinator()
    {
        return $this->planningCoordinator;
    }

    /**
     * @return string
     */
    public function getNumeroUrgence()
    {
        return $this->numeroUrgence;
    }

    /**
     * @param string $numeroUrgence
     */
    public function setNumeroUrgence($numeroUrgence)
    {
        $this->numeroUrgence = $numeroUrgence;
    }


}

