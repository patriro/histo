<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\HistoryController;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['company']],
    denormalizationContext: ['groups' => ['post']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            uriTemplate: '/company/{id}/history',
            controller: HistoryController::class,
        ),
    ],
)]
#[Gedmo\Loggable]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company', 'post'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company', 'post'])]
    #[Gedmo\Versioned]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company', 'post'])]
    #[Gedmo\Versioned]
    private ?string $siren = null;

    #[ORM\Column]
    #[Groups(['company', 'post'])]
    #[Gedmo\Versioned]
    private ?int $capital = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Address::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['company', 'post'])]
    private Collection $addresses;

    #[ORM\ManyToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['company', 'post'])]
    #[Gedmo\Versioned]
    private ?LegalStatus $legalStatus = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['company', 'post'])]
    #[Gedmo\Versioned]
    private ?\DateTimeInterface $registrationDate = null;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
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

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getCapital(): ?int
    {
        return $this->capital;
    }

    public function setCapital(int $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->setCompany($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getCompany() === $this) {
                $address->setCompany(null);
            }
        }

        return $this;
    }

    public function getLegalStatus(): ?LegalStatus
    {
        return $this->legalStatus;
    }

    public function setLegalStatus(?LegalStatus $legalStatus): self
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        if ($this->registrationDate !== $registrationDate) {
            $this->registrationDate = $registrationDate;
        }

        return $this;
    }
}
