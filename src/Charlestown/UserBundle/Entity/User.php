<?php

namespace Charlestown\UserBundle\Entity;

use Charlestown\FileBundle\Entity\File;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\UserBundle\Entity\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "collaborator" = "Charlestown\CollaboratorBundle\Entity\Collaborator", "customer" = "Charlestown\CustomerBundle\Entity\Customer"})
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
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", nullable=true)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="pc", type="string", nullable=true)
     */
    private $pc;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", nullable=true)
     */
    private $phoneNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isClubMember", type="boolean", nullable=true)
     */
    private $isClubMember;

     /**
      * @var \Agency
      *
      * @ORM\ManyToOne(targetEntity="Charlestown\AgencyBundle\Entity\Agency")
      */
    private $agency;

    /**
      * @var \File
      *
      * @ORM\OneToOne(targetEntity="Charlestown\FileBundle\Entity\File", cascade={"persist"})
      */
    private $picture;

    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
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

    /**
     * @return string
     */
    public function getphoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setphoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return boolean
     */
    public function isIsClubMember()
    {
        return $this->isClubMember;
    }

    /**
     * @param boolean $isClubMember
     */
    public function setIsClubMember($isClubMember)
    {
        $this->isClubMember = $isClubMember;
    }


    /**
     * @return \Agency
    */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param \Agency $agency
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
    }

    /**
     * @return \File
    */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param \File $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
}

