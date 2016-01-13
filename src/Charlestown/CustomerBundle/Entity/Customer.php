<?php

namespace Charlestown\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Charlestown\UserBundle\Entity\User as User;

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\CustomerBundle\Entity\CustomerRepository")
 */
class Customer extends User
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
     * @ORM\Column(name="companyName", type="string")
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string")
     */
    private $siret;
//
//    /**
//     * @var \respPlanning
//     *
//     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator")
//     * @ORM\JoinColumn(name="respPlanning_id", referencedColumnName="id", nullable=true)
//     */
//    private $respPlanning;
//
//    /**
//     * @var \respCustomer
//     *
//     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator")
//     * @ORM\JoinColumn(name="respCustomer_id", referencedColumnName="id", nullable=true)
//     */
//    private $respCustomer;

    public function __construct(){
        parent::__construct();
    }

//    /**
//     * @return \respPlanning
//     */
//    public function getRespPlanning()
//    {
//        return $this->respPlanning;
//    }
//
//    /**
//     * @param \respPlanning $respPlanning
//     */
//    public function setRespPlanning($respPlanning)
//    {
//        $this->respPlanning = $respPlanning;
//    }
//
//    /**
//     * @return \respCustomer
//     */
//    public function getRespCustomer()
//    {
//        return $this->respCustomer;
//    }
//
//    /**
//     * @param \respCustomer $respCustomer
//     */
//    public function setRespCustomer($respCustomer)
//    {
//        $this->respCustomer = $respCustomer;
//    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param string $siret
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
    }

}

