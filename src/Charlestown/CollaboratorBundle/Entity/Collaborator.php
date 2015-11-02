<?php

namespace Charlestown\CollaboratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Charlestown\UserBundle\Entity\User as User;

/**
 * Collaborator
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\CollaboratorBundle\Entity\CollaboratorRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"collaborator" = "Collaborator", "businessSupport" = "BusinessSupport", "event" = "Event"})
 */
abstract class Collaborator extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}

