<?php

namespace App\Entity;

use App\Repository\TrackingConnectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: TrackingConnectionRepository::class)]
#[ORM\Table(name: 'tracking_connexion', options: ['comment' => 'Table de traçage des connexions des utilisateurs Symfony.'])]
class TrackingConnection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['comment' => "Identifiant unique de la connexion effectuée"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, options: ['comment' => "Email de l'utilisateur"])]
    private ?string $email = null;

    #[ORM\Column(length: 255, options: ['comment' => "Message de la connexion (AUTHENT OK, KO, EXPIRED)"])]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['comment' => "Le moment où la connexion a été effectuée"])]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }
}
