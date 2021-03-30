<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdditionalOutputLecturerRepository")
 */
class AdditionalOutputLecturer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="additionalOutputLecturers")
     * @Assert\NotNull(message="Dosen harus dipilih")
     */
    private $lecturer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AdditionalOutput", inversedBy="additionalOutputLecturers")
     */
    private $additionalOutput;

    public function __toString()
    {
        return $this->getLecturer()->getName();
    }

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

    public function getAdditionalOutput(): ?AdditionalOutput
    {
        return $this->additionalOutput;
    }

    public function setAdditionalOutput(?AdditionalOutput $additionalOutput): self
    {
        $this->additionalOutput = $additionalOutput;

        return $this;
    }
}
