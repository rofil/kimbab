<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Book
{
    const CLASSIFICATION_RESEARCH = 1;
    const CLASSIFICATION_COMMUNITY_SERVICE = 2;
    
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfPages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $publisher;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $isbn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Year", inversedBy="books")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $edition;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="books", fetch="EAGER")
     */
    private $uploader;

    /**
     * @ORM\Column(type="integer")
     */
    private $classification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookLecturer", mappedBy="book", cascade={"persist", "remove"}, fetch="EAGER", orphanRemoval=true)
     * @Assert\Valid
     */
    private $bookLecturers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BookCategory", inversedBy="books")
     */
    private $category;

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
        $this->bookLecturers = new ArrayCollection();
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

    public function getNumberOfPages(): ?int
    {
        return $this->numberOfPages;
    }

    public function setNumberOfPages(?int $numberOfPages): self
    {
        $this->numberOfPages = $numberOfPages;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

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

    public function getEdition(): ?string
    {
        return $this->edition;
    }

    public function setEdition(?string $edition): self
    {
        $this->edition = $edition;

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
     * @return Collection|BookLecturer[]
     */
    public function getBookLecturers(): Collection
    {
        return $this->bookLecturers;
    }

    public function addBookLecturer(BookLecturer $bookLecturer): self
    {
        if (!$this->bookLecturers->contains($bookLecturer)) {
            $this->bookLecturers[] = $bookLecturer;
            $bookLecturer->setBook($this);
        }

        return $this;
    }

    public function removeBookLecturer(BookLecturer $bookLecturer): self
    {
        if ($this->bookLecturers->contains($bookLecturer)) {
            $this->bookLecturers->removeElement($bookLecturer);
            // set the owning side to null (unless already changed)
            if ($bookLecturer->getBook() === $this) {
                $bookLecturer->setBook(null);
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

    public function getCategory(): ?BookCategory
    {
        return $this->category;
    }

    public function setCategory(?BookCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getBookLecturers()->count() == 0) {
            $context->buildViolation("Penulis Buku Minimal 1 Orang Dosen")
                ->atPath("bookLecturers")
                ->addViolation();
        }
    }
}
