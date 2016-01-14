<?php

namespace Charlestown\CollaboratorBundle\Entity;

use Charlestown\FileBundle\Entity\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BusinessSupport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\CollaboratorBundle\Entity\BusinessSupportRepository")
 */
class BusinessSupport extends Collaborator
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
     * @var \Files
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     */
    private $evaluations;

    /**
     * @var string
     *
     * @ORM\Column(name="syndicat", type="string", nullable=true)
     */
    private $syndicat;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
        parent::__construct();
    }


    /**
     * @return \Files
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * @param \Files $evaluations
     */
    public function setEvaluations($evaluations)
    {
        $this->evaluations = $evaluations;
    }

    /**
     * @param File $evaluation
     */
    public function addEvaluation(File $evaluation)
    {
        $this->evaluations[] = $evaluation;
    }

    /**
     * @return string
     */
    public function getSyndicat()
    {
        return $this->syndicat;
    }

    /**
     * @param string $syndicat
     */
    public function setSyndicat($syndicat)
    {
        $this->syndicat = $syndicat;
    }
}

