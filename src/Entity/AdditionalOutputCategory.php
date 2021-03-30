<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdditionalOutputCategoryRepository")
 */
class AdditionalOutputCategory
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdditionalOutput", mappedBy="category")
     */
    private $additionalOutputs;

    public function __construct()
    {
        $this->additionalOutputs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $additionalOutput->setCategory($this);
        }

        return $this;
    }

    public function removeAdditionalOutput(AdditionalOutput $additionalOutput): self
    {
        if ($this->additionalOutputs->contains($additionalOutput)) {
            $this->additionalOutputs->removeElement($additionalOutput);
            // set the owning side to null (unless already changed)
            if ($additionalOutput->getCategory() === $this) {
                $additionalOutput->setCategory(null);
            }
        }

        return $this;
    }
}
