<?php

namespace Charlestown\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\UserBundle\Entity\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "customer" = "Charlestown\CustomerBundle\Entity\Customer", "collaborator" = "Charlestown\CollaboratorBundle\Entity\Collaborator"})
 */
abstract class User extends FOSUser
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
     * @ORM\Column(name="address", type="string")
     */
    public $address;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string")
     */
    public $town;

    /**
     * @var string
     *
     * @ORM\Column(name="pc", type="string")
     */
    public $pc;

    public function __construct()
    {
        parent::__construct();
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

    public function __toString(){
        return $this->getUsername();
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     */
    public function setTown($town)
    {
        $this->town = $town;
    }

    /**
     * @return string
     */
    public function getPc()
    {
        return $this->pc;
    }

    /**
     * @param string $pc
     */
    public function setPc($pc)
    {
        $this->pc = $pc;
    }
}

