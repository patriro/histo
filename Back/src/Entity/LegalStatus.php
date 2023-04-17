<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LegalStatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LegalStatusRepository::class)]
#[ApiResource]
class LegalStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company', 'post'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('company')]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
