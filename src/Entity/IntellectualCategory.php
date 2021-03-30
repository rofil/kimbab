<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IntellectualCategoryRepository")
 */
class IntellectualCategory
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IntellectualProperty", mappedBy="category")
     */
    private $intellectualProperties;



    public function __construct()
    {
        $this->intellectualProperties = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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
            $intellectualProperty->setCategory($this);
        }

        return $this;
    }

    public function removeIntellectualProperty(IntellectualProperty $intellectualProperty): self
    {
        if ($this->intellectualProperties->contains($intellectualProperty)) {
            $this->intellectualProperties->removeElement($intellectualProperty);
            // set the owning side to null (unless already changed)
            if ($intellectualProperty->getCategory() === $this) {
                $intellectualProperty->setCategory(null);
            }
        }

        return $this;
    }
}
