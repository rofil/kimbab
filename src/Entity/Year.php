<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YearRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Year
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
    private $year;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IntellectualProperty", mappedBy="year")
     */
    private $intellectualProperties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="year")
     */
    private $books;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommunityService", mappedBy="year")
     */
    private $communityServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Journal", mappedBy="year")
     */
    private $journals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conference", mappedBy="year")
     */
    private $conferences;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdditionalOutput", mappedBy="year")
     */
    private $additionalOutputs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConferenceOrganizer", mappedBy="year")
     */
    private $conferenceOrganizers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmploymentContract", mappedBy="year")
     */
    private $employmentContracts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Research", mappedBy="year")
     */
    private $researches;

    public function __construct()
    {
        $this->intellectualProperties = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->communityServices = new ArrayCollection();
        $this->journals = new ArrayCollection();
        $this->conferences = new ArrayCollection();
        $this->additionalOutputs = new ArrayCollection();
        $this->conferenceOrganizers = new ArrayCollection();
        $this->employmentContracts = new ArrayCollection();
        $this->researches = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->year;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
     * @throws \Exception
     * @ORM\PreFlush()
     */
    public function onFlush()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function onPersist()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @return Collection|IntellectualProperty[]
     */
    public function getIntellectualProperties(): Collection
    {
        return $this->intellectualProperties;
    }

    public function addIntellectualProperty(IntellectualProperty $intellectualProperty): self
    {
        if (!$this->intellectualProperties->contains($intellectualProperty)) {
            $this->intellectualProperties[] = $intellectualProperty;
            $intellectualProperty->setYear($this);
        }

        return $this;
    }

    public function removeIntellectualProperty(IntellectualProperty $intellectualProperty): self
    {
        if ($this->intellectualProperties->contains($intellectualProperty)) {
            $this->intellectualProperties->removeElement($intellectualProperty);
            // set the owning side to null (unless already changed)
            if ($intellectualProperty->getYear() === $this) {
                $intellectualProperty->setYear(null);
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
            $book->setYear($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            // set the owning side to null (unless already changed)
            if ($book->getYear() === $this) {
                $book->setYear(null);
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
            $communityService->setYear($this);
        }

        return $this;
    }

    public function removeCommunityService(CommunityService $communityService): self
    {
        if ($this->communityServices->contains($communityService)) {
            $this->communityServices->removeElement($communityService);
            // set the owning side to null (unless already changed)
            if ($communityService->getYear() === $this) {
                $communityService->setYear(null);
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
            $journal->setYear($this);
        }

        return $this;
    }

    public function removeJournal(Journal $journal): self
    {
        if ($this->journals->contains($journal)) {
            $this->journals->removeElement($journal);
            // set the owning side to null (unless already changed)
            if ($journal->getYear() === $this) {
                $journal->setYear(null);
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
            $conference->setYear($this);
        }

        return $this;
    }

    public function removeConference(Conference $conference): self
    {
        if ($this->conferences->contains($conference)) {
            $this->conferences->removeElement($conference);
            // set the owning side to null (unless already changed)
            if ($conference->getYear() === $this) {
                $conference->setYear(null);
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
            $additionalOutput->setYear($this);
        }

        return $this;
    }

    public function removeAdditionalOutput(AdditionalOutput $additionalOutput): self
    {
        if ($this->additionalOutputs->contains($additionalOutput)) {
            $this->additionalOutputs->removeElement($additionalOutput);
            // set the owning side to null (unless already changed)
            if ($additionalOutput->getYear() === $this) {
                $additionalOutput->setYear(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConferenceOrganizer[]
     */
    public function getConferenceOrganizers(): Collection
    {
        return $this->conferenceOrganizers;
    }

    public function addConferenceOrganizer(ConferenceOrganizer $conferenceOrganizer): self
    {
        if (!$this->conferenceOrganizers->contains($conferenceOrganizer)) {
            $this->conferenceOrganizers[] = $conferenceOrganizer;
            $conferenceOrganizer->setYear($this);
        }

        return $this;
    }

    public function removeConferenceOrganizer(ConferenceOrganizer $conferenceOrganizer): self
    {
        if ($this->conferenceOrganizers->contains($conferenceOrganizer)) {
            $this->conferenceOrganizers->removeElement($conferenceOrganizer);
            // set the owning side to null (unless already changed)
            if ($conferenceOrganizer->getYear() === $this) {
                $conferenceOrganizer->setYear(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EmploymentContract[]
     */
    public function getEmploymentContracts(): Collection
    {
        return $this->employmentContracts;
    }

    public function addEmploymentContract(EmploymentContract $employmentContract): self
    {
        if (!$this->employmentContracts->contains($employmentContract)) {
            $this->employmentContracts[] = $employmentContract;
            $employmentContract->setYear($this);
        }

        return $this;
    }

    public function removeEmploymentContract(EmploymentContract $employmentContract): self
    {
        if ($this->employmentContracts->contains($employmentContract)) {
            $this->employmentContracts->removeElement($employmentContract);
            // set the owning side to null (unless already changed)
            if ($employmentContract->getYear() === $this) {
                $employmentContract->setYear(null);
            }
        }

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
            $research->setYear($this);
        }

        return $this;
    }

    public function removeResearch(Research $research): self
    {
        if ($this->researches->contains($research)) {
            $this->researches->removeElement($research);
            // set the owning side to null (unless already changed)
            if ($research->getYear() === $this) {
                $research->setYear(null);
            }
        }

        return $this;
    }
}
