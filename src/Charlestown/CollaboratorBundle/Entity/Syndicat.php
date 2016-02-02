<?php

namespace Charlestown\CollaboratorBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Syndicat
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Syndicat
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \BusinessSupport
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\CollaboratorBundle\Entity\BusinessSupport")
     */
    private $users;


    public function __construct(){
        $this->users = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Syndicat
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set users
     *
     * @param \BusinessSupport $users
     *
     * @return Syndicat
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \BusinessSupport
     */
    public function getUsers()
    {
        return $this->users;
    }
}

