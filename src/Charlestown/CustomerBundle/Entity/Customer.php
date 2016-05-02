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

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinColumn(name="uniform_ae_id", referencedColumnName="id", nullable=true)
     */
    private $uniformAE;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinColumn(name="uniform_event_id", referencedColumnName="id", nullable=true)
     */
    private $uniformEvent;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinColumn(name="manual_id", referencedColumnName="id", nullable=true)
     */
    private $manual;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinColumn(name="contract_id", referencedColumnName="id", nullable=true)
     */
    private $contract;

    /**
     * @var \File
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     */
    private $bills;

    /**
     * @var \Operation
     *
     * @ORM\OneToMany(targetEntity="Charlestown\OperationBundle\Entity\Operation", mappedBy="customer")
     */
    private $operations;

    /**
     * @var \Book
     *
     * @ORM\OneToOne(targetEntity="Charlestown\CustomerBundle\Entity\Book", mappedBy="customer")
     */
    private $book;

    /**
     * @var \File
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinTable(name="customer_contradictoryControls")
     */
    private $contradictoryControls;

    /**
     * @var \File
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinTable(name="customer_siteControls")
     */
    private $siteControls;

    /**
     * @var \File
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinTable(name="customer_mysteriouscalls")
     */
    private $mysteriousCalls;

    /**
     * @var \File
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinTable(name="customer_mysteriousvisits")
     */
    private $mysteriousVisits;

    /**
     * @var \File
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinTable(name="customer_reports")
     */
    private $activityReports;

    /**
     * @var \File
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinTable(name="customer_investigations")
     */
    private $investigations;

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

    /**
     * @return \User
     */
    public function getUniformAE()
    {
        return $this->uniformAE;
    }

    /**
     * @param \User $uniform
     */
    public function setUniformAE($uniform)
    {
        $this->uniformAE = $uniform;
    }

    /**
     * @return \User
     */
    public function getUniformEvent()
    {
        return $this->uniformEvent;
    }

    /**
     * @param \User $uniform
     */
    public function setUniformEvent($uniform)
    {
        $this->uniformEvent = $uniform;
    }

    /**
     * @return \File
     */
    public function getManual()
    {
        return $this->manual;
    }

    /**
     * @param \File $manual
     */
    public function setManual($manual)
    {
        $this->manual = $manual;
    }

    /**
     * @return \File
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * @param \File $contract
     */
    public function setContract($contract)
    {
        $this->contract = $contract;
    }

    /**
     * @return \File
     */
    public function getBills()
    {
        return $this->bills;
    }

    /**
     * @param \File $bills
     */
    public function setBills($bills)
    {
        $this->bills = $bills;
    }

    /**
     * @return \Operation
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * @param \Operation $operations
     */
    public function setOperations($operations)
    {
        $this->operations = $operations;
    }

    /**
     * @return mixed
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param mixed $book
     */
    public function setBook($book)
    {
        $this->book = $book;
    }

    /**
     * @return \File
     */
    public function getContradictoryControls()
    {
        return $this->contradictoryControls;
    }

    /**
     * @param \File $contradictoryControls
     */
    public function setContradictoryControls($contradictoryControls)
    {
        $this->contradictoryControls = $contradictoryControls;
    }

    /**
     * @return \File
     */
    public function getSiteControls()
    {
        return $this->siteControls;
    }

    /**
     * @param \File $siteControls
     */
    public function setSiteControls($siteControls)
    {
        $this->siteControls = $siteControls;
    }

    /**
     * @return \File
     */
    public function getMysteriousCalls()
    {
        return $this->mysteriousCalls;
    }

    /**
     * @param \File $mysteriousCalls
     */
    public function setMysteriousCalls($mysteriousCalls)
    {
        $this->mysteriousCalls = $mysteriousCalls;
    }

    /**
     * @return \File
     */
    public function getActivityReports()
    {
        return $this->activityReports;
    }

    /**
     * @param \File $activityReports
     */
    public function setActivityReports($activityReports)
    {
        $this->activityReports = $activityReports;
    }

    /**
     * @return \File
     */
    public function getInvestigations()
    {
        return $this->investigations;
    }

    /**
     * @param \File $investigations
     */
    public function setInvestigations($investigations)
    {
        $this->investigations = $investigations;
    }

    /**
     * @return \File
     */
    public function getMysteriousVisits()
    {
        return $this->mysteriousVisits;
    }

    /**
     * @param \File $mysteriousVisits
     */
    public function setMysteriousVisits($mysteriousVisits)
    {
        $this->mysteriousVisits = $mysteriousVisits;
    }
}

