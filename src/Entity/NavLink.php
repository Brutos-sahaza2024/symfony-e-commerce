<?php

namespace App\Entity;

use App\Repository\NavlinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NavlinkRepository::class)]
class NavLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NameLink = null;

    #[ORM\Column(length: 255)]
    private ?string $NameUrl = null;

    #[ORM\Column]
    private ?string $Category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameLink(): ?string
    {
        return $this->NameLink;
    }

    public function setNameLink(string $NameLink): static
    {
        $this->NameLink = $NameLink;

        return $this;
    }

    public function getNameUrl(): ?string
    {
        return $this->NameUrl;
    }

    public function setNameUrl(string $NameUrl): static
    {
        $this->NameUrl = $NameUrl;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): static
    {
        $this->Category = $Category;

        return $this;
    }
}