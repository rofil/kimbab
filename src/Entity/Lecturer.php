<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LecturerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Lecturer
{
    const JAFUNG = [0 => 'Unkown', 1 => 'Tenaga Pengajar', 2=>'Asisten Ahli', 3 => 'Lektor', 4 => 'Lektor Kepala', 5 => 'Guru Besar'];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nidn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unit", inversedBy="lecturers")
     */
    private $unit;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $education;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    private $educationLevel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IntellectualProperty", mappedBy="author", cascade={"remove", "persist"})
     */
    private $ownIntellectualProperties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IntellectualPropertyLecturer", mappedBy="lecturer")
     */
    private $intellectualPropertyLecturers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="uploader")
     */
    private $books;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookLecturer", mappedBy="lecturer")
     */
    private $bookLecturers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommunityService", mappedBy="uploader")
     */
    private $communityServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommunityServiceLecturer", mappedBy="lecturer")
     */
    private $communityServiceLecturers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Journal", mappedBy="uploader")
     */
    private $journals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JournalLecturer", mappedBy="lecturer")
     */
    private $journalLecturers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conference", mappedBy="uploader")
     */
    private $conferences;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConferenceLecturer", mappedBy="lecturer")
     */
    private $conferenceLecturers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdditionalOutput", mappedBy="uploader")
     */
    private $additionalOutputs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdditionalOutputLecturer", mappedBy="lecturer", cascade={"remove"})
     */
    private $additionalOutputLecturers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $affiliation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @Assert\Image()
     */
    protected $filePhoto;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="lecturers")
     */
    private $creator;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lecturer", mappedBy="creator")
     */
    private $lecturers;

    /**
     * @ORM\Column(type="integer")
     */
    private $functional;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program", inversedBy="lecturers")
     */
    private $program;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Research", mappedBy="uploader")
     */
    private $researches;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Research", mappedBy="lecturers")
     */
    private $myResearches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResearchLecturer", mappedBy="lecturer")
     */
    private $researchLecturers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $expertises;

    /**
     * @return mixed
     */
    public function getFilePhoto(): ?UploadedFile
    {
        return $this->filePhoto;
    }

    /**
     * @param mixed $filePhoto
     */
    public function setFilePhoto(UploadedFile $filePhoto): self
    {
        $this->filePhoto = $filePhoto;

        return $this;
    }


    public function __construct()
    {
        $this->ownIntellectualProperties = new ArrayCollection();
        $this->intellectualPropertyLecturers = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->bookLecturers = new ArrayCollection();
        $this->communityServices = new ArrayCollection();
        $this->communityServiceLecturers = new ArrayCollection();
        $this->journals = new ArrayCollection();
        $this->journalLecturers = new ArrayCollection();
        $this->conferences = new ArrayCollection();
        $this->conferenceLecturers = new ArrayCollection();
        $this->additionalOutputs = new ArrayCollection();
        $this->additionalOutputLecturers = new ArrayCollection();
        $this->lecturers = new ArrayCollection();
        $this->researches = new ArrayCollection();
        $this->myResearches = new ArrayCollection();
        $this->researchLecturers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function setEducationLevel($edu) 
    {
        
    }

    public function getEducationLevel()
    {
        $education_list = [
            1 => 'S-1',
            2 => 'S-2',
            3 => 'S-3',
        ];

        if (array_key_exists($this->getEducation(), $education_list))
            return $education_list[$this->getEducation()];
        
        return "~";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(string $nip): self
    {
        $this->nip = $nip;

        return $this;
    }

    public function getNidn(): ?string
    {
        return $this->nidn;
    }

    public function setNidn(string $nidn): self
    {
        $this->nidn = $nidn;

        return $this;
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

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getEducation(): ?int
    {
        return $this->education;
    }

    public function setEducation(int $education): self
    {
        $this->education = $education;

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
     * @ORM\PreFlush
     */
    public function onFlush()
    {
        $this->setUpdatedAt(new \Datetime());
    }

    /**
     * @ORM\PrePersist
     */
    public function onPersist()
    {
        $this->setCreatedAt(new \Datetime());
    }

    /**
     * @return Collection|IntellectualProperty[]
     */
    public function getOwnIntellectualProperties(): Collection
    {
        return $this->ownIntellectualProperties;
    }

    public function addOwnIntellectualProperty(IntellectualProperty $ownIntellectualProperty): self
    {
        if (!$this->ownIntellectualProperties->contains($ownIntellectualProperty)) {
            $this->ownIntellectualProperties[] = $ownIntellectualProperty;
            $ownIntellectualProperty->setAuthor($this);
        }

        return $this;
    }

    public function removeOwnIntellectualProperty(IntellectualProperty $ownIntellectualProperty): self
    {
        if ($this->ownIntellectualProperties->contains($ownIntellectualProperty)) {
            $this->ownIntellectualProperties->removeElement($ownIntellectualProperty);
            // set the owning side to null (unless already changed)
            if ($ownIntellectualProperty->getAuthor() === $this) {
                $ownIntellectualProperty->setAuthor(null);
            }
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
            $this->intellectualPropertyLecturers[] = $intellectualPropertyLecturer;
            $intellectualPropertyLecturer->setLecturer($this);
        }

        return $this;
    }

    public function removeIntellectualPropertyLecturer(IntellectualPropertyLecturer $intellectualPropertyLecturer): self
    {
        if ($this->intellectualPropertyLecturers->contains($intellectualPropertyLecturer)) {
            $this->intellectualPropertyLecturers->removeElement($intellectualPropertyLecturer);
            // set the owning side to null (unless already changed)
            if ($intellectualPropertyLecturer->getLecturer() === $this) {
                $intellectualPropertyLecturer->setLecturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setUploader($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            // set the owning side to null (unless already changed)
            if ($book->getUploader() === $this) {
                $book->setUploader(null);
            }
        }

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
            $bookLecturer->setLecturer($this);
        }

        return $this;
    }

    public function removeBookLecturer(BookLecturer $bookLecturer): self
    {
        if ($this->bookLecturers->contains($bookLecturer)) {
            $this->bookLecturers->removeElement($bookLecturer);
            // set the owning side to null (unless already changed)
            if ($bookLecturer->getLecturer() === $this) {
                $bookLecturer->setLecturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommunityService[]
     */
    public function getCommunityServices(): Collection
    {
        return $this->communityServices;
    }

    public function addCommunityService(CommunityService $communityService): self
    {
        if (!$this->communityServices->contains($communityService)) {
            $this->communityServices[] = $communityService;
            $communityService->setUploader($this);
        }

        return $this;
    }

    public function removeCommunityService(CommunityService $communityService): self
    {
        if ($this->communityServices->contains($communityService)) {
            $this->communityServices->removeElement($communityService);
            // set the owning side to null (unless already changed)
            if ($communityService->getUploader() === $this) {
                $communityService->setUploader(null);
            }
        }

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
            $this->communityServiceLecturers[] = $communityServiceLecturer;
            $communityServiceLecturer->setLecturer($this);
        }

        return $this;
    }

    public function removeCommunityServiceLecturer(CommunityServiceLecturer $communityServiceLecturer): self
    {
        if ($this->communityServiceLecturers->contains($communityServiceLecturer)) {
            $this->communityServiceLecturers->removeElement($communityServiceLecturer);
            // set the owning side to null (unless already changed)
            if ($communityServiceLecturer->getLecturer() === $this) {
                $communityServiceLecturer->setLecturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Journal[]
     */
    public function getJournals(): Collection
    {
        return $this->journals;
    }

    public function addJournal(Journal $journal): self
    {
        if (!$this->journals->contains($journal)) {
            $this->journals[] = $journal;
            $journal->setUploader($this);
        }

        return $this;
    }

    public function removeJournal(Journal $journal): self
    {
        if ($this->journals->contains($journal)) {
            $this->journals->removeElement($journal);
            // set the owning side to null (unless already changed)
            if ($journal->getUploader() === $this) {
                $journal->setUploader(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|JournalLecturer[]
     */
    public function getJournalLecturers(): Collection
    {
        return $this->journalLecturers;
    }

    public function addJournalLecturer(JournalLecturer $journalLecturer): self
    {
        if (!$this->journalLecturers->contains($journalLecturer)) {
            $this->journalLecturers[] = $journalLecturer;
            $journalLecturer->setLecturer($this);
        }

        return $this;
    }

    public function removeJournalLecturer(JournalLecturer $journalLecturer): self
    {
        if ($this->journalLecturers->contains($journalLecturer)) {
            $this->journalLecturers->removeElement($journalLecturer);
            // set the owning side to null (unless already changed)
            if ($journalLecturer->getLecturer() === $this) {
                $journalLecturer->setLecturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conference[]
     */
    public function getConferences(): Collection
    {
        return $this->conferences;
    }

    public function addConference(Conference $conference): self
    {
        if (!$this->conferences->contains($conference)) {
            $this->conferences[] = $conference;
            $conference->setUploader($this);
        }

        return $this;
    }

    public function removeConference(Conference $conference): self
    {
        if ($this->conferences->contains($conference)) {
            $this->conferences->removeElement($conference);
            // set the owning side to null (unless already changed)
            if ($conference->getUploader() === $this) {
                $conference->setUploader(null);
            }
        }

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
            $conferenceLecturer->setLecturer($this);
        }

        return $this;
    }

    public function removeConferenceLecturer(ConferenceLecturer $conferenceLecturer): self
    {
        if ($this->conferenceLecturers->contains($conferenceLecturer)) {
            $this->conferenceLecturers->removeElement($conferenceLecturer);
            // set the owning side to null (unless already changed)
            if ($conferenceLecturer->getLecturer() === $this) {
                $conferenceLecturer->setLecturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AdditionalOutput[]
     */
    public function getAdditionalOutputs(): Collection
    {
        return $this->additionalOutputs;
    }

    public function addAdditionalOutput(AdditionalOutput $additionalOutput): self
    {
        if (!$this->additionalOutputs->contains($additionalOutput)) {
            $this->additionalOutputs[] = $additionalOutput;
            $additionalOutput->setUploader($this);
        }

        return $this;
    }

    public function removeAdditionalOutput(AdditionalOutput $additionalOutput): self
    {
        if ($this->additionalOutputs->contains($additionalOutput)) {
            $this->additionalOutputs->removeElement($additionalOutput);
            // set the owning side to null (unless already changed)
            if ($additionalOutput->getUploader() === $this) {
                $additionalOutput->setUploader(null);
            }
        }

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
            $additionalOutputLecturer->setLecturer($this);
        }

        return $this;
    }

    public function removeAdditionalOutputLecturer(AdditionalOutputLecturer $additionalOutputLecturer): self
    {
        if ($this->additionalOutputLecturers->contains($additionalOutputLecturer)) {
            $this->additionalOutputLecturers->removeElement($additionalOutputLecturer);
            // set the owning side to null (unless already changed)
            if ($additionalOutputLecturer->getLecturer() === $this) {
                $additionalOutputLecturer->setLecturer(null);
            }
        }

        return $this;
    }

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function setAffiliation(string $affiliation): self
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreator(): ?self
    {
        return $this->creator;
    }

    public function setCreator(?self $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getLecturers(): Collection
    {
        return $this->lecturers;
    }

    public function addLecturer(self $lecturer): self
    {
        if (!$this->lecturers->contains($lecturer)) {
            $this->lecturers[] = $lecturer;
            $lecturer->setCreator($this);
        }

        return $this;
    }

    public function removeLecturer(self $lecturer): self
    {
        if ($this->lecturers->contains($lecturer)) {
            $this->lecturers->removeElement($lecturer);
            // set the owning side to null (unless already changed)
            if ($lecturer->getCreator() === $this) {
                $lecturer->setCreator(null);
            }
        }

        return $this;
    }

    public function getFunctional(): ?int
    {
        return $this->functional;
    }

    public function setFunctional(int $functional): self
    {
        $this->functional = $functional;

        return $this;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    /**
     * @return Collection|Research[]
     */
    public function getResearches(): Collection
    {
        return $this->researches;
    }

    public function addResearch(Research $research): self
    {
        if (!$this->researches->contains($research)) {
            $this->researches[] = $research;
            $research->setUploader($this);
        }

        return $this;
    }

    public function removeResearch(Research $research): self
    {
        if ($this->researches->contains($research)) {
            $this->researches->removeElement($research);
            // set the owning side to null (unless already changed)
            if ($research->getUploader() === $this) {
                $research->setUploader(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Research[]
     */
    public function getMyResearches(): Collection
    {
        return $this->myResearches;
    }

    public function addMyResearch(Research $myResearch): self
    {
        if (!$this->myResearches->contains($myResearch)) {
            $this->myResearches[] = $myResearch;
            $myResearch->addLecturer($this);
        }

        return $this;
    }

    public function removeMyResearch(Research $myResearch): self
    {
        if ($this->myResearches->contains($myResearch)) {
            $this->myResearches->removeElement($myResearch);
            $myResearch->removeLecturer($this);
        }

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
            $this->researchLecturers[] = $researchLecturer;
            $researchLecturer->setLecturer($this);
        }

        return $this;
    }

    public function removeResearchLecturer(ResearchLecturer $researchLecturer): self
    {
        if ($this->researchLecturers->contains($researchLecturer)) {
            $this->researchLecturers->removeElement($researchLecturer);
            // set the owning side to null (unless already changed)
            if ($researchLecturer->getLecturer() === $this) {
                $researchLecturer->setLecturer(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getExpertises(): ?string
    {
        return $this->expertises;
    }

    public function setExpertises(?string $expertises): self
    {
        $this->expertises = $expertises;

        return $this;
    }

}
