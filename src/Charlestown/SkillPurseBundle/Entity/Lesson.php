<?php

namespace Charlestown\SkillPurseBundle\Entity;

use Charlestown\CollaboratorBundle\Entity\Collaborator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lesson
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Charlestown\SkillPurseBundle\Entity\LessonRepository")
 */
class Lesson
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
     * @var \DateTime
     *
     * @ORM\Column(name="startAt", type="datetime")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endAt", type="datetime")
     */
    private $endAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="room", type="integer")
     */
    private $room;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string")
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="pc", type="string")
     */
    private $pc;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \Collaborator
     *
     * @ORM\ManyToOne(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="myLessons")
     */
    private $teacher;

    /**
     * @var \Collaborators
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="lessons")
     * @ORM\JoinTable(name="lesson_selection")
     */
    private $students;

    /**
     * @var \Collaborators
     *
     * @ORM\ManyToMany(targetEntity="Charlestown\CollaboratorBundle\Entity\Collaborator", inversedBy="lessonsApplication")
     * @ORM\JoinTable(name="lesson_application")
     */
    private $studentsApplicants;


    public function __construct(){
        $this->students = new ArrayCollection();
        $this->studentsApplicants = new ArrayCollection();
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
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return Lesson
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     *
     * @return Lesson
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * @return int
     */
    public function getRoom()
    {
        $room = $this->room - $this->students->count();

        return $room;
    }

    /**
     * @param int $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param string $localisation
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Lesson
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set teacher
     *
     * @param \stdClass $teacher
     *
     * @return Lesson
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \stdClass
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set students
     *
     * @param \stdClass $students
     *
     * @return Lesson
     */
    public function setStudents($students)
    {
        $this->students = $students;

        return $this;
    }

    /**
     * Get students
     *
     * @return \stdClass
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @return \Collaborators
     */
    public function getStudentsApplicants()
    {
        return $this->studentsApplicants;
    }

    /**
     * @param \Collaborators $studentsApplicants
     */
    public function setStudentsApplicants($studentsApplicants)
    {
        $this->studentsApplicants = $studentsApplicants;
    }

    public function addStudent(Collaborator $student){
        $this->students[] = $student;
    }

    public function addStudentApplicant(Collaborator $student){
        $this->studentsApplicants[] = $student;
    }

    public function removeApplicant(Collaborator $applicant){
        $this->studentsApplicants->removeElement($applicant);
    }

    public function removeSelected(Collaborator $applicant){
        $this->students->removeElement($applicant);
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     */
    public function setTown($town)
    {
        $this->town = $town;
    }

    /**
     * @return string
     */
    public function getPc()
    {
        return $this->pc;
    }

    /**
     * @param string $pc
     */
    public function setPc($pc)
    {
        $this->pc = $pc;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}

