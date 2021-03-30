<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("units")
 * @ORM\Entity(repositoryClass="App\Repository\FacultyRepository")
 */
class Unit
{
    const TYPE_FACULTY = 1;
    const TYPE_LEMBAGA = 2;

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
     * @ORM\Column(type="string", length=255)
     */
    private $abbreviation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program", mappedBy="unit")
     */
    private $programs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lecturer", mappedBy="unit")
     */
    private $lecturers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConferenceOrganizer", mappedBy="unit")
     */
    private $conferenceOrganizers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmploymentContract", mappedBy="unit")
     */
    private $employmentContracts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="unit")
     */
    private $accounts;

    /**
     * @ORM\Column(type="integer")
     */
    private $unitType;


    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->programs = new ArrayCollection();
        $this->lecturers = new ArrayCollection();
        $this->conferenceOrganizers = new ArrayCollection();
        $this->employmentContracts = new ArrayCollection();
        $this->accounts = new ArrayCollection();
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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->setUnit($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->contains($program)) {
            $this->programs->removeElement($program);
            // set the owning side to null (unless already changed)
            if ($program->getUnit() === $this) {
                $program->setUnit(null);
            }
        }

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
            $lecturer->setUnit($this);
        }

        return $this;
    }

    public function removeLecturer(Lecturer $lecturer): self
    {
        if ($this->lecturers->contains($lecturer)) {
            $this->lecturers->removeElement($lecturer);
            // set the owning side to null (unless already changed)
            if ($lecturer->getUnit() === $this) {
                $lecturer->setUnit(null);
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
            $conferenceOrganizer->setUnit($this);
        }

        return $this;
    }

    public function removeConferenceOrganizer(ConferenceOrganizer $conferenceOrganizer): self
    {
        if ($this->conferenceOrganizers->contains($conferenceOrganizer)) {
            $this->conferenceOrganizers->removeElement($conferenceOrganizer);
            // set the owning side to null (unless already changed)
            if ($conferenceOrganizer->getUnit() === $this) {
                $conferenceOrganizer->setUnit(null);
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
            $employmentContract->setUnit($this);
        }

        return $this;
    }

    public function removeEmploymentContract(EmploymentContract $employmentContract): self
    {
        if ($this->employmentContracts->contains($employmentContract)) {
            $this->employmentContracts->removeElement($employmentContract);
            // set the owning side to null (unless already changed)
            if ($employmentContract->getUnit() === $this) {
                $employmentContract->setUnit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(User $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setUnit($this);
        }

        return $this;
    }

    public function removeAccount(User $account): self
    {
        if ($this->accounts->contains($account)) {
            $this->accounts->removeElement($account);
            // set the owning side to null (unless already changed)
            if ($account->getUnit() === $this) {
                $account->setUnit(null);
            }
        }

        return $this;
    }

    public function getUnitType(): ?int
    {
        return $this->unitType;
    }

    public function setUnitType(int $unitType): self
    {
        $this->unitType = $unitType;

        return $this;
    }
}
