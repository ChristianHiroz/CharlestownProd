<?php

namespace Charlestown\OperationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Timeslot
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\OperationBundle\Entity\TimeslotRepository")
 */
class Timeslot
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
     * @ORM\Column(name="start", type="string", length=25)
     */
    private $start;

    /**
     * @var string
     *
     * @ORM\Column(name="end", type="string", length=25)
     */
    private $end;

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
     * Set start
     *
     * @param string $start
     *
     * @return Timeslot
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param string $end
     *
     * @return Timeslot
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
    }

    public function __toString(){
        return $this->getStart(). '/' . $this->getEnd();
    }
}

