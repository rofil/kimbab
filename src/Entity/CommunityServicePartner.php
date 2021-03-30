<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommunityServicePartnerRepository")
 */
class CommunityServicePartner
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
     * @ORM\Column(type="string", length=255)
     */
    private $businessEntity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $increaseInProfit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fundingProvision;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CommunityService", inversedBy="communityServicePartners")
     */
    private $communityService;

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

    public function getBusinessEntity(): ?string
    {
        return $this->businessEntity;
    }

    public function setBusinessEntity(string $businessEntity): self
    {
        $this->businessEntity = $businessEntity;

        return $this;
    }

    public function getIncreaseInProfit(): ?float
    {
        return $this->increaseInProfit;
    }

    public function setIncreaseInProfit(?float $increaseInProfit): self
    {
        $this->increaseInProfit = $increaseInProfit;

        return $this;
    }

    public function getFundingProvision(): ?float
    {
        return $this->fundingProvision;
    }

    public function setFundingProvision(?float $fundingProvision): self
    {
        $this->fundingProvision = $fundingProvision;

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
