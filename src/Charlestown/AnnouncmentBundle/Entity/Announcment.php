<?php

namespace Charlestown\AnnouncmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Announcment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\AnnouncmentBundle\Entity\AnnouncmentRepository")
 */
class Announcment
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;

    /**
     * @var \File
     *
     * @ORM\OneToOne(targetEntity="Charlestown\FileBundle\Entity\File")
     */
    private $picture;

    /**
     * @var \Collaborator
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="myOffers")
     */
    private $offerer;

    /**
     * @var \Collaborator
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="myOffersApplications")
     */
    private $applicant;

    public function __construct(){
        $this->visible = true;
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
     * @return Announcment
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
     * @return Announcment
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
     * @return Announcment
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
     * @return boolean
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }


    /**
     * Set picture
     *
     * @param \stdClass $picture
     *
     * @return Announcment
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \stdClass
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set offerer
     *
     * @param \stdClass $offerer
     *
     * @return Announcment
     */
    public function setOfferer($offerer)
    {
        $this->offerer = $offerer;

        return $this;
    }

    /**
     * Get offerer
     *
     * @return \stdClass
     */
    public function getOfferer()
    {
        return $this->offerer;
    }


    /**
     * Set applicant
     *
     * @param \stdClass $applicant
     *
     * @return Announcment
     */
    public function setApplicant($applicant)
    {
        $this->applicant = $applicant;

        return $this;
    }

    /**
     * Get applicant
     *
     * @return \stdClass
     */
    public function getApplicant()
    {
        return $this->applicant;
    }
}

