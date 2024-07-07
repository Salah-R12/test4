<?php

namespace App\Entity;

use App\Repository\TrackingActionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: TrackingActionRepository::class)]
#[ORM\Table(name: 'tracking_action', options: ['comment' => 'Table de tracage des actions des utilisateurs Symfony.'])]
class TrackingAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['comment' => "Identifiant unique de l'action effectuée"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, options: ['comment' => "Table affectée par l'action de l'utilisateur"], name: 'nom_table')]
    private ?string $tablename = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['comment' => "Le moment où l'action a été effectuée"], name: 'date_action')]
    private ?\DateTimeInterface $dateaction = null;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE", name: 'user_id', referencedColumnName: 'id', options: ['comment' => "L'utilisateur ayant effectué l'action"])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNomTable(): ?string
    {
        return $this->tablename;
    }

    public function setNomTable(string $tablename): self
    {
        $this->tablename = $tablename;

        return $this;
    }

    public function getDateAction(): ?\DateTimeInterface
    {
        return $this->dateaction;
    }

    public function setDateAction(\DateTimeInterface $dateaction): self
    {
        $this->dateaction = $dateaction;

        return $this;
    }
}
