<?php

namespace App\Entity;


use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Entity\Trait\CreatedAtTrait;


#[ORM\Entity(repositoryClass: ChatRepository::class)]

class Chat
{
    use CreatedAtTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

 


    #[ORM\Column(length: 255)]
    private ?string $message = null;

 

    #[ORM\Column]
    private ?int $idsender = null;
    #[ORM\Column]
    private ?int $idreciption = null;



   
    public function __construct()
    {
        
        $this->created_at = new \DateTimeImmutable();
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
  

    public function getId(): ?int
    {
        return $this->id;
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



    public function getIdsender(): ?int
    {
        return $this->idsender;
    }

    public function setIdsender(int $idsender): static
    {
        $this->idsender = $idsender;

        return $this;
    }


    public function getIdreciption(): ?int
    {
        return $this->idreciption;
    }

    public function setIdreciption(int $idreciption): static
    {
        $this->idreciption = $idreciption;

        return $this;
    }


    
    


}