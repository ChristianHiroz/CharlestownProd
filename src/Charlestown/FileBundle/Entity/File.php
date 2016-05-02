<?php

namespace Charlestown\FileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 * @ORM\Entity(repositoryClass="Charlestown\FileBundle\Entity\FileRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 */
class File
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
     * @var \FileType
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\FileBundle\Entity\FileType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=true)
     */
    private $fileType;

    private $file;
    private $tempFilenom;

    public function __construct(){
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

    /**
     * Get fileType
     *
     * @return FileType
     */
    public function getFileType(){
        return $this->fileType;
    }

    /**
     * Set fileType
     *
     * @param FileType $fileType
     */
    public function setFileType(FileType $fileType = null){
        $this->fileType = $fileType;
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
        if($this->name != ""){
            return $this->name;
        }
        else{
            return "filerror";
        }
    }
}
