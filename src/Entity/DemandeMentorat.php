<?php

namespace App\Entity;

use App\Repository\DemandeMentoratRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeMentoratRepository::class)]
class DemandeMentorat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_mentor = null;

    #[ORM\Column]
    private ?int $id_mentee = null;

    #[ORM\Column]
    private ?int $offer = null;
 
    #[ORM\Column(length: 255)]
    private ?string $message = null;

    #[ORM\Column(type: 'boolean')]
    private $aproved  = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMentor(): ?int
    {
        return $this->id_mentor;
    }

    public function setIdMentor(int $id_mentor): static
    {
        $this->id_mentor = $id_mentor;

        return $this;
    }

    public function getIdMentee(): ?int
    {
        return $this->id_mentee;
    }

    public function setIdMentee(int $id_mentee): static
    {
        $this->id_mentee = $id_mentee;

        return $this;
    }
    public function setoffer(int $offer): static
    {
        $this->offer = $offer;

        return $this;
    }

    public function getoffer(): ?int
    {
        return $this->offer;
    }
    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }

    public function isAproved(): ?bool
    {
        return $this->aproved;
    }

    public function setAproved(bool $aproved): static
    {
        $this->aproved = $aproved;

        return $this;
    }
}
