<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'emails', indexes: [
    new ORM\Index(name: 'index_email_hash', columns: ['hash'])
])]
class Email
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: '`from`', type: 'string', length: 255)]
    private string $from;

    #[ORM\Column(name: '`to`', type: 'string', length: 255)]
    private string $to;

    #[ORM\Column(type: 'string', length: 255)]
    private string $subject;

    #[ORM\Column(type: 'text')]
    private string $body;

    #[ORM\Column(type: 'string', length: 64, unique: true)]
    private string $hash;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $sentAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private EmailStatus $status;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getSentAt(): ?DateTime
    {
        return $this->sentAt;
    }

    public function setSentAt(?DateTime $sentAt): void
    {
        $this->sentAt = $sentAt;
    }

    public function getStatus(): EmailStatus
    {
        return $this->status;
    }

    public function setStatus(EmailStatus $status): void
    {
        $this->status = $status;
    }

}
