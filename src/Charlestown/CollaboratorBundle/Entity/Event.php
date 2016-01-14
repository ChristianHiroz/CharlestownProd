<?php

namespace Charlestown\CollaboratorBundle\Entity;

use Charlestown\OperationBundle\Entity\OperationAppliance;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\CollaboratorBundle\Entity\EventRepository")
 */
class Event extends Collaborator
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
     * @var \OperationAppliance
     *
     * @ORM\OneToMany(targetEntity="Charlestown\OperationBundle\Entity\OperationAppliance", mappedBy="event")
     */
    private $appliances;

    public function __construct()
    {
        parent::__construct();
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
}

