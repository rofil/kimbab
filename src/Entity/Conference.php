<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConferenceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Conference
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameOfConference;

    /**
     * @ORM\Column(type="integer")
     */
    private $typeOfParticipation;

    /**
     * @ORM\Column(type="date")
     */
    private $conferenceDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    /**
     * @ORM\Column(type="smallint")
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="conferences")
     */
    private $uploader;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Year", inversedBy="conferences")
     */
    private $year;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConferenceLecturer", mappedBy="conference", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $conferenceLecturers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @ORM\Column(type="smallint")
     */
    private $classification;

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"application/pdf", "application/x-pdf", "application/zip", "image/png", "image/jpg", "image/jpeg", "application/x-rar", "application/msword", "application/msword"},
     *     mimeTypesMessage="File dalam bentuk pdf, gambar, zip, rar, docx atau doc"
     * )
     */
    protected $documentFile;

    /**
     * @return mixed
     */
    public function getDocumentFile():?UploadedFile
    {
        return $this->documentFile;
    }

    /**
     * @param mixed $documentFile
     */
    public function setDocumentFile(?UploadedFile $documentFile): self
    {
        $this->documentFile = $documentFile;

        return $this;
    }



    public function __construct()
    {
        $this->conferenceLecturers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNameOfConference(): ?string
    {
        return $this->nameOfConference;
    }

    public function setNameOfConference(string $nameOfConference): self
    {
        $this->nameOfConference = $nameOfConference;

        return $this;
    }

    public function getTypeOfParticipation(): ?int
    {
        return $this->typeOfParticipation;
    }

    public function setTypeOfParticipation(int $typeOfParticipation): self
    {
        $this->typeOfParticipation = $typeOfParticipation;

        return $this;
    }

    public function getConferenceDate(): ?\DateTimeInterface
    {
        return $this->conferenceDate;
    }

    public function setConferenceDate(\DateTimeInterface $conferenceDate): self
    {
        $this->conferenceDate = $conferenceDate;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getUploader(): ?Lecturer
    {
        return $this->uploader;
    }

    public function setUploader(?Lecturer $uploader): self
    {
        $this->uploader = $uploader;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|ConferenceLecturer[]
     */
    public function getConferenceLecturers(): Collection
    {
        return $this->conferenceLecturers;
    }

    public function addConferenceLecturer(ConferenceLecturer $conferenceLecturer): self
    {
        if (!$this->conferenceLecturers->contains($conferenceLecturer)) {
            $this->conferenceLecturers[] = $conferenceLecturer;
            $conferenceLecturer->setConference($this);
        }

        return $this;
    }

    public function removeConferenceLecturer(ConferenceLecturer $conferenceLecturer): self
    {
        if ($this->conferenceLecturers->contains($conferenceLecturer)) {
            $this->conferenceLecturers->removeElement($conferenceLecturer);
            // set the owning side to null (unless already changed)
            if ($conferenceLecturer->getConference() === $this) {
                $conferenceLecturer->setConference(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PreFlush()
     */
    public function onFlush()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPersist()
    {
        $this->setCreatedAt(new \DateTime());
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
        if ($this->getConferenceLecturers()->count() == 0) {
            $context->buildViolation("Personel Dosen minimal 1 Orang Dosen")
                ->atPath("conferenceLecturers")
                ->addViolation();
        }
    }
}
