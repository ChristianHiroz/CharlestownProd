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
    public $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string")
     */
    public $siret;

    public function __construct(){
        parent::__construct();
    }

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

