<?php

namespace Charlestown\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Devis
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Charlestown\CustomerBundle\Entity\DevisRepository")
 */
class Devis
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
     * @ORM\Column(name="duree", type="string", length=50)
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="startAt", type="string", length=50)
     */
    private $startAt;

    /**
     * @var string
     *
     * @ORM\Column(name="endAt", type="string", length=50)
     */
    private $endAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbHote", type="integer")
     */
    private $nbHote;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="prestationType", type="string", length=50)
     */
    private $prestationType;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CustomerBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

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
     * Set duree
     *
     * @param string $duree
     *
     * @return Devis
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return string
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set startAt
     *
     * @param string $startAt
     *
     * @return Devis
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return string
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param string $endAt
     *
     * @return Devis
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return string
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set nbHote
     *
     * @param integer $nbHote
     *
     * @return Devis
     */
    public function setNbHote($nbHote)
    {
        $this->nbHote = $nbHote;

        return $this;
    }

    /**
     * Get nbHote
     *
     * @return integer
     */
    public function getNbHote()
    {
        return $this->nbHote;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Devis
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
     * Set type
     *
     * @param string $type
     *
     * @return Devis
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
     * Set prestationType
     *
     * @param string $prestationType
     *
     * @return Devis
     */
    public function setPrestationType($prestationType)
    {
        $this->prestationType = $prestationType;

        return $this;
    }

    /**
     * Get prestationType
     *
     * @return string
     */
    public function getPrestationType()
    {
        return $this->prestationType;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }
}

