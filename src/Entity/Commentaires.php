<?php

namespace App\Entity;


use App\Repository\CommentairesRepository;
use Doctrine\DBAL\Types\Types;
use App\Entity\Mentoroffers;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CommentairesRepository::class)]
class Commentaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::TEXT)]
    private ?string $Commentaire = null;

    #[ORM\Column]
    private ?int $Note = null;

    #[ORM\Column(name: "user_id", type: Types::INTEGER)] // Define the user_id column
    private ?int $user_id = null; // Add the user_id property

    // Ajouter une relation ManyToOne avec User
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(string $Commentaire): static
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->Note;
    }

    public function setNote(int $Note): static
    {
        $this->Note = $Note;

        return $this;
    }

    // Ajouter les méthodes pour gérer la relation avec User
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
