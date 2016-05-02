<?php

namespace Charlestown\ChatBundle\Entity;

use Charlestown\CollaboratorBundle\Entity\Collaborator;
use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\ChatBundle\Entity\MessageRepository")
 */
class Message
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
     * @var Collaborator
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator")
     */
    private $writer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="writedAt", type="datetime")
     */
    private $writedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=500)
     */
    private $message;

    public function __construct(){
        $this->writedAt = new \DateTime();
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
     * Set writer
     *
     * @param \stdClass $writer
     *
     * @return Message
     */
    public function setWriter($writer)
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * Get writer
     *
     * @return \stdClass
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * Set writedAt
     *
     * @param \DateTime $writedAt
     *
     * @return Message
     */
    public function setWritedAt($writedAt)
    {
        $this->writedAt = $writedAt;

        return $this;
    }

    /**
     * Get writedAt
     *
     * @return \DateTime
     */
    public function getWritedAt()
    {
        return $this->writedAt;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}

