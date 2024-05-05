<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
// Ajoutez ceci en haut de votre fichier PHP
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFileName = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $from_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $to_date = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $color = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->from_date;
    }

    public function setFromDate(\DateTimeInterface $from_date): static
    {
        $this->from_date = $from_date;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->to_date;
    }

    public function setToDate(\DateTimeInterface $to_date): static
    {
        $this->to_date = $to_date;

        return $this;
    }
    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }
    
  public function getImageFileName(): ?string
{
    return $this->imageFileName;
}

public function setImageFileName(?string $imageFileName): static
{
    $this->imageFileName = $imageFileName;

    return $this;
}
}
