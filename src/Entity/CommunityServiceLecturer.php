<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CommunityServiceLecturerRepository")
 */
class CommunityServiceLecturer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="communityServiceLecturers")
     * @Assert\NotNull(message="Dosen harus dipilih")
     */
    private $lecturer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CommunityService", inversedBy="communityServiceLecturers")
     */
    private $communityService;


    public function __toString()
    {
        return $this->getLecturer()->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLecturer(): ?Lecturer
    {
        return $this->lecturer;
    }

    public function setLecturer(?Lecturer $lecturer): self
    {
        $this->lecturer = $lecturer;

        return $this;
    }

    public function getCommunityService(): ?CommunityService
    {
        return $this->communityService;
    }

    public function setCommunityService(?CommunityService $communityService): self
    {
        $this->communityService = $communityService;

        return $this;
    }

}
