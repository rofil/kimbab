<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JournalLecturerRepository")
 */
class JournalLecturer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="journalLecturers")
     * @Assert\NotNull(message="Dosen harus dipilih")
     */
    private $lecturer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Journal", inversedBy="journalLecturers")
     */
    private $journal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderNumber;

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

    public function getJournal(): ?Journal
    {
        return $this->journal;
    }

    public function setJournal(?Journal $journal): self
    {
        $this->journal = $journal;

        return $this;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(?int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }
}
