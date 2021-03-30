<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IntellectualPropertyRepository")
 */
class IntellectualProperty
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Year", inversedBy="intellectualProperties")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\IntellectualCategory", inversedBy="intellectualProperties")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"application/pdf", "application/x-pdf", "application/zip", "image/png", "image/jpg", "image/jpeg", "application/x-rar", "application/msword", "application/msword"},
     *     mimeTypesMessage="File dalam bentuk pdf, gambar, zip, rar, docx atau doc"
     * )
     */
    private $documentFile;

    private $lecturerList;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="ownIntellectualProperties")
     */
    private $author;

    private $contributors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IntellectualPropertyLecturer", mappedBy="intellectualProperty", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $intellectualPropertyLecturers;

    /**
     * @ORM\Column(type="smallint")
     */
    private $classification;


    public function __construct()
    {

        $this->contributors = new ArrayCollection();
        $this->intellectualPropertyLecturers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;

    }

    /**
     * @return mixed
     */
    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /**
     * @param mixed $file
     */
    public function setDocumentFile(UploadedFile $file): void
    {
        $this->documentFile = $file;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getYear(): ?Year
    {
        return $this->year;
    }

    public function setYear(?Year $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCategory(): ?IntellectualCategory
    {
        return $this->category;
    }

    public function setCategory(?IntellectualCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLecturerList()
    {
        $l = [];
        foreach ($this->getIntellectualPropertyLecturers() as $lecturer)
            $l[] = $lecturer->getLecturer()->getName();
        return implode(", ", $l);

    }

    public function getAuthor(): ?Lecturer
    {
        return $this->author;
    }

    public function setAuthor(?Lecturer $author): self
    {
        $this->author = $author;

        return $this;
    }



    /**
     * @return mixed
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * @param Lecturer $contributors
     * @return self
     */
    public function addContributor(Lecturer $contributor): self
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors[] = $contributor;
        }

        return $this;

    }

    /**
     * @return Collection|IntellectualPropertyLecturer[]
     */
    public function getIntellectualPropertyLecturers(): Collection
    {
        return $this->intellectualPropertyLecturers;
    }

    public function addIntellectualPropertyLecturer(IntellectualPropertyLecturer $intellectualPropertyLecturer): self
    {
        if (!$this->intellectualPropertyLecturers->contains($intellectualPropertyLecturer)) {
            $intellectualPropertyLecturer->setIntellectualProperty($this);
            $this->intellectualPropertyLecturers[] = $intellectualPropertyLecturer;
        }

        return $this;
    }

    public function removeIntellectualPropertyLecturer(IntellectualPropertyLecturer $intellectualPropertyLecturer): self
    {
        if ($this->intellectualPropertyLecturers->contains($intellectualPropertyLecturer)) {
            $this->intellectualPropertyLecturers->removeElement($intellectualPropertyLecturer);
            // set the owning side to null (unless already changed)
            if ($intellectualPropertyLecturer->getIntellectualProperty() === $this) {
                $intellectualPropertyLecturer->setIntellectualProperty(null);
            }
        }



        return $this;
    }

    public function getClassification(): ?int
    {
        return $this->classification;
    }

    public function setClassification(int $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getIntellectualPropertyLecturers()->count() == 0) {
            $context->buildViolation("Anggota Peneliti minimal 1 Orang")
                ->atPath("intellectualPropertyLecturers")
                ->addViolation();
        }
    }


}
