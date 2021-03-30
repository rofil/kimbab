<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IntellectualPropertyLecturerRepository")
 */
class IntellectualPropertyLecturer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="intellectualPropertyLecturers")
     * @Assert\NotNull(message="Dosen harus dipilih")
     */
    private $lecturer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\IntellectualProperty", inversedBy="intellectualPropertyLecturers")
     *
     */
    private $intellectualProperty;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIntellectualProperty(): ?IntellectualProperty
    {
        return $this->intellectualProperty;
    }

    public function setIntellectualProperty(?IntellectualProperty $intellectualProperty): self
    {
        $this->intellectualProperty = $intellectualProperty;

        return $this;
    }
}
