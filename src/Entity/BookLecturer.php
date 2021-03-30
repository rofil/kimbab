<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookLecturerRepository")
 */
class BookLecturer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="bookLecturers")
     * @Assert\NotNull(message="Dosen harus dipilih")
     */
    private $lecturer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="bookLecturers")
     */
    private $book;


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

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

}
