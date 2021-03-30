<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdditionalOutputRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class AdditionalOutput
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="additionalOutputs")
     */
    private $uploader;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Year", inversedBy="additionalOutputs")
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



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdditionalOutputLecturer", mappedBy="additionalOutput", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid
     */
    private $additionalOutputLecturers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AdditionalOutputCategory", inversedBy="additionalOutputs")
     */
    private $category;

    public function __construct()
    {
        $this->additionalOutputLecturers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return Collection|AdditionalOutputLecturer[]
     */
    public function getAdditionalOutputLecturers(): Collection
    {
        return $this->additionalOutputLecturers;
    }

    public function addAdditionalOutputLecturer(AdditionalOutputLecturer $additionalOutputLecturer): self
    {
        if (!$this->additionalOutputLecturers->contains($additionalOutputLecturer)) {
            $this->additionalOutputLecturers[] = $additionalOutputLecturer;
            $additionalOutputLecturer->setAdditionalOutput($this);
        }

        return $this;
    }

    public function removeAdditionalOutputLecturer(AdditionalOutputLecturer $additionalOutputLecturer): self
    {
        if ($this->additionalOutputLecturers->contains($additionalOutputLecturer)) {
            $this->additionalOutputLecturers->removeElement($additionalOutputLecturer);
            // set the owning side to null (unless already changed)
            if ($additionalOutputLecturer->getAdditionalOutput() === $this) {
                $additionalOutputLecturer->setAdditionalOutput(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PreFlush
     */
    public function onFlush()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function onPersist()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function getCategory(): ?AdditionalOutputCategory
    {
        return $this->category;
    }

    public function setCategory(?AdditionalOutputCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getAdditionalOutputLecturers()->count() == 0) {
            $context->buildViolation("Personel minimal 1 Orang")
                ->atPath("additionalOutputLecturers")
                ->addViolation();
        }
    }
}
