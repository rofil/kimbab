<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommunityServiceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CommunityService
{
    use TimestampsTrait;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Year", inversedBy="communityServices")
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fundingSource;

    /**
     * @ORM\Column(type="float")
     */
    private $funding;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfStudents;

    /**
     * @ORM\Column(type="float")
     */
    private $numberOfAlumni;

    /**
     * @ORM\Column(type="float")
     */
    private $numberOfStaff;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="communityServices")
     */
    private $uploader;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommunityServiceLecturer", mappedBy="communityService", cascade={"persist","remove"})
     * @Assert\Valid
     */
    private $communityServiceLecturers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommunityServicePartner", mappedBy="communityService", cascade={"persist","remove"})
     * @Assert\Valid
     */
    private $communityServicePartners;

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
    public function setDocumentFile(UploadedFile $documentFile): self
    {
        $this->documentFile = $documentFile;

        return $this;
    }


    public function __construct()
    {
        $this->communityServiceLecturers = new ArrayCollection();
        $this->communityServicePartners = new ArrayCollection();
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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

    public function getNumberOfStudents(): ?int
    {
        return $this->numberOfStudents;
    }

    public function setNumberOfStudents(int $numberOfStudents): self
    {
        $this->numberOfStudents = $numberOfStudents;

        return $this;
    }

    public function getNumberOfAlumni(): ?float
    {
        return $this->numberOfAlumni;
    }

    public function setNumberOfAlumni(float $numberOfAlumni): self
    {
        $this->numberOfAlumni = $numberOfAlumni;

        return $this;
    }

    public function getNumberOfStaff(): ?float
    {
        return $this->numberOfStaff;
    }

    public function setNumberOfStaff(float $numberOfStaff): self
    {
        $this->numberOfStaff = $numberOfStaff;

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

    public function getUploader(): ?Lecturer
    {
        return $this->uploader;
    }

    public function setUploader(?Lecturer $uploader): self
    {
        $this->uploader = $uploader;

        return $this;
    }

    /**
     * @return Collection|CommunityServiceLecturer[]
     */
    public function getCommunityServiceLecturers(): Collection
    {
        return $this->communityServiceLecturers;
    }

    public function addCommunityServiceLecturer(CommunityServiceLecturer $communityServiceLecturer): self
    {
        if (!$this->communityServiceLecturers->contains($communityServiceLecturer)) {
            $communityServiceLecturer->setCommunityService($this);
            $this->communityServiceLecturers->add($communityServiceLecturer);
        }

        return $this;
    }

    public function removeCommunityServiceLecturer(CommunityServiceLecturer $communityServiceLecturer): self
    {
        if ($this->communityServiceLecturers->contains($communityServiceLecturer)) {
            $this->communityServiceLecturers->removeElement($communityServiceLecturer);
            // set the owning side to null (unless already changed)
            if ($communityServiceLecturer->getCommunityService() === $this) {
                $communityServiceLecturer->setCommunityService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommunityServicePartner[]
     */
    public function getCommunityServicePartners(): Collection
    {
        return $this->communityServicePartners;
    }

    public function addCommunityServicePartner(CommunityServicePartner $communityServicePartner): self
    {
        if (!$this->communityServicePartners->contains($communityServicePartner)) {
            $this->communityServicePartners[] = $communityServicePartner;
            $communityServicePartner->setCommunityService($this);
        }

        return $this;
    }

    public function removeCommunityServicePartner(CommunityServicePartner $communityServicePartner): self
    {
        if ($this->communityServicePartners->contains($communityServicePartner)) {
            $this->communityServicePartners->removeElement($communityServicePartner);
            // set the owning side to null (unless already changed)
            if ($communityServicePartner->getCommunityService() === $this) {
                $communityServicePartner->setCommunityService(null);
            }
        }

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getCommunityServiceLecturers()->count() == 0) {
            $context->buildViolation("Anggota personil minimal 1 Orang Dosen")
                ->atPath("communityServiceLecturers")
                ->addViolation();
        }

        if ($this->getCommunityServicePartners()->count() == 0) {
            $context->buildViolation("Jumlah mitra minimal 1 mitra")
                ->atPath("communityServicePartners")
                ->addViolation();
        }
    }
}
