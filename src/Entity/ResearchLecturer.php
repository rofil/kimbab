<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResearchLecturerRepository")
 * @ORM\Table("researches_lecturers")
 */
class ResearchLecturer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Research", inversedBy="researchLecturers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $research;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="researchLecturers")
     */
    private $lecturer;

    public function __toString()
    {
        return $this->getLecturer()->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResearch(): ?Research
    {
        return $this->research;
    }

    public function setResearch(?Research $research): self
    {
        $this->research = $research;

        return $this;
    }

    public function getLecturer(): ?Lecturer
    {
        return $this->lecturer;
    }

    public function setLecturer(?Lecturer $lecturer): self
    {
        $this->lecturer = $lecturer;

        return $this;
    }
}
