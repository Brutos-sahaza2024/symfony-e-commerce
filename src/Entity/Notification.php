<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $creatdAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isRead = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?SupportTicket $supportTicket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatdAt(): ?\DateTimeImmutable
    {
        return $this->creatdAt;
    }

    public function setCreatdAt(?\DateTimeImmutable $creatdAt): static
    {
        $this->creatdAt = $creatdAt;

        return $this;
    }

    public function isRead(): ?bool
    {
        return $this->isRead;
    }

    public function setRead(?bool $isRead): static
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getSupportTicket(): ?SupportTicket
    {
        return $this->supportTicket;
    }

    public function setSupportTicket(?SupportTicket $supportTicket): static
    {
        $this->supportTicket = $supportTicket;

        return $this;
    }
}
