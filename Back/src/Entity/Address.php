<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ApiResource]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('company')]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Groups(['company', 'post'])]
    private ?string $number = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company', 'post'])]
    private ?string $roadType = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company', 'post'])]
    private ?string $roadName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company', 'post'])]
    private ?string $city = null;

    #[ORM\Column]
    #[Groups(['company', 'post'])]
    private ?int $postCode = null;

    #[ORM\ManyToOne(inversedBy: 'addresses')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['company', 'post'])]
    private ?Company $company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getRoadType(): ?string
    {
        return $this->roadType;
    }

    public function setRoadType(string $roadType): self
    {
        $this->roadType = $roadType;

        return $this;
    }

    public function getRoadName(): ?string
    {
        return $this->roadName;
    }

    public function setRoadName(string $roadName): self
    {
        $this->roadName = $roadName;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    public function setPostCode(int $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
