<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ResearchRepository")
 */
class Research
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Year", inversedBy="researches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="researches")
     */
    private $uploader;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fundingSource;

    /**
     * @ORM\Column(type="float")
     */
    private $funding;

    /**
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Lecturer", inversedBy="myResearches")
     *
     */
    private $lecturers;

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
    private $fileDocument;

    /**
     * @return mixed
     */
    public function getFileDocument():?UploadedFile
    {
        return $this->fileDocument;
    }

    /**
     * @param UploadedFile $fileDocument
     *
     * @return self
     */
    public function setFileDocument(?UploadedFile $fileDocument): self
    {
        $this->fileDocument = $fileDocument;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResearchLecturer", mappedBy="research", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $researchLecturers;

    public function __construct()
    {
        $this->lecturers = new ArrayCollection();
        $this->researchLecturers = new ArrayCollection();
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

    public function getYear(): ?Year
    {
        return $this->year;
    }

    public function setYear(?Year $year): self
    {
        $this->year = $year;

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

    public function getFundingSource(): ?string
    {
        return $this->fundingSource;
    }

    public function setFundingSource(string $fundingSource): self
    {
        $this->fundingSource = $fundingSource;

        return $this;
    }

    public function getFunding(): ?float
    {
        return $this->funding;
    }

    public function setFunding(float $funding): self
    {
        $this->funding = $funding;

        return $this;
    }

    /**
     * @return Collection|Lecturer[]
     */
    public function getLecturers(): Collection
    {
        return $this->lecturers;
    }

    public function addLecturer(Lecturer $lecturer): self
    {
        if (!$this->lecturers->contains($lecturer)) {
            $this->lecturers[] = $lecturer;
        }

        return $this;
    }

    public function removeLecturer(Lecturer $lecturer): self
    {
        if ($this->lecturers->contains($lecturer)) {
            $this->lecturers->removeElement($lecturer);
        }

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
     * @return Collection|ResearchLecturer[]
     */
    public function getResearchLecturers(): Collection
    {
        return $this->researchLecturers;
    }

    public function addResearchLecturer(ResearchLecturer $researchLecturer): self
    {
        if (!$this->researchLecturers->contains($researchLecturer)) {
            $researchLecturer->setResearch($this);
            $this->researchLecturers[] = $researchLecturer;

        }

        return $this;
    }

    public function removeResearchLecturer(ResearchLecturer $researchLecturer): self
    {
        if ($this->researchLecturers->contains($researchLecturer)) {
            $this->researchLecturers->removeElement($researchLecturer);
            // set the owning side to null (unless already changed)
            if ($researchLecturer->getResearch() === $this) {
                $researchLecturer->setResearch(null);
            }
        }

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getResearchLecturers()->count() == 0) {
            $context->buildViolation("Anggota Peneliti minimal 1 Orang Peneliti")
            ->atPath("researchLecturers")
            ->addViolation();
        }
    }
}
