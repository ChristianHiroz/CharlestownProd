<?php

namespace Charlestown\CollaboratorBundle\Entity;

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

    public function __construct()
    {
        parent::__construct();
    }
}

