<?php

namespace Charlestown\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\BlogBundle\Entity\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="string", length=500)
     */
    private $texte;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible_collaborator", type="boolean", nullable = true)
     */
    private $visibleCollaborator = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible_customer", type="boolean", nullable = true)
     */
    private $visibleCustomer = false;

    /**
     * @var bollean
     *
     * @ORM\Column(name="action", type="boolean", nullable = true)
     */
    private $action = false;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\FileBundle\Entity\File")
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id", nullable=true)
     */
    private $picture;

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
     * @return Article
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
     * Set texte
     *
     * @param string $texte
     *
     * @return Article
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @return bollean
     */
    public function getVisibleCollaborator()
    {
        return $this->visibleCollaborator;
    }

    /**
     * @param bollean $visibleCollaborator
     */
    public function setVisibleCollaborator($visibleCollaborator)
    {
        $this->visibleCollaborator = $visibleCollaborator;
    }

    /**
     * @return bollean
     */
    public function getVisibleCustomer()
    {
        return $this->visibleCustomer;
    }

    /**
     * @param bollean $visibleCustomer
     */
    public function setVisibleCustomer($visibleCustomer)
    {
        $this->visibleCustomer = $visibleCustomer;
    }


    /**
     * Set picture
     *
     * @param \stdClass $picture
     *
     * @return Article
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
     * @return bollean
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param bollean $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
}

