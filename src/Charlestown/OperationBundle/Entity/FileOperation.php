<?php

namespace Charlestown\OperationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 * @ORM\Entity(repositoryClass="Charlestown\FileBundle\Entity\FileRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 */
class FileOperation
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
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_show", type="string", length=255, nullable=true)
     */
    private $nameShow;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * @var boolean
     *
     * @ORM\Column(name="accepted", type="boolean")
     */
    private $accepted;

    /**
     * @var \FileType
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\OperationBundle\Entity\Operation")
     */
    private $operation;
    /**
     * @var \FileType
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CustomerBundle\Entity\Customer")
     */
    private $customer;

    private $file;
    private $tempFilenom;

    public function __construct(){
        $this->accepted = false;
        $this->date = new \DateTime();
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
     * Set alt
     *
     * @param string $alt
     * @return File
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
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
     * Set nameShow
     *
     * @param string $nameShow
     * @return File
     */
    public function setNameShow($nameShow)
    {
        $this->nameShow = $nameShow;

        return $this;
    }

    /**
     * Get nameShow
     *
     * @return string
     */
    public function getNameShow()
    {
        if($this->nameShow == null){
            return $this->name;
        }
        return $this->nameShow;
    }


    /**
     * Set file
     *
     * @param File $file
     * @return File
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\File $file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getDate(){
        return $this->date;
    }

    //Final render : supportId- supportNom/ficheClass/ficheId- ficheNom, FichePrenom/fileId.fileAlt
    public function getUploadRootDir()
    {
        return 'uploads/files/';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->alt = $this->file->guessExtension();
            $this->name = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->id.'.'.$this->file->guessExtension());

        unset($this->file);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenomForRemove()
    {
        $this->tempFilenom = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->tempFilenom) {
            unlink($this->tempFilenom);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->alt ? null : $this->getUploadRootDir().'/'.$this->id.'.'.$this->alt;
    }

    public function __toString(){
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isAccepted()
    {
        return $this->accepted;
    }

    /**
     * @param boolean $accepted
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
    }

    /**
     * @return \FileType
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param \FileType $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return \FileType
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param \FileType $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }
}
