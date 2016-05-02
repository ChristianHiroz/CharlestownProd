<?php

namespace Charlestown\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\CustomerBundle\Entity\BookRepository")
 */
class Book
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
     * @var \Customer
     *
     * @ORM\OneToOne(targetEntity="Charlestown\CustomerBundle\Entity\Customer", inversedBy="book")
     */
    private $customer;

    /**
     * @var \Files
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\FileBundle\Entity\File")
     */
    private $uniforms;


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
     * Set customer
     *
     * @param \stdClass $customer
     *
     * @return Book
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \stdClass
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set uniforms
     *
     * @param \stdClass $uniforms
     *
     * @return Book
     */
    public function setUniforms($uniforms)
    {
        $this->uniforms = $uniforms;

        return $this;
    }

    /**
     * Get uniforms
     *
     * @return \stdClass
     */
    public function getUniforms()
    {
        return $this->uniforms;
    }


}

