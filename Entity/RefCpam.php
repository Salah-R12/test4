<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RefCpamRepository;

#[ORM\Entity(repositoryClass: RefCpamRepository::class)]
#[ORM\Table(name: 'ref_cpam', options: ['comment' => 'Table des CPAM'])]
class RefCpam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'cpam_id', options: ['comment' => 'L\'identifiant unique de la CPAM'])]
    private ?int $cpamId = null;

    #[ORM\ManyToOne(targetEntity: RefCes::class, inversedBy: 'cpams')]
    #[ORM\JoinColumn(name: 'ref_ces_id', referencedColumnName: 'ces_id', nullable: false, options: ['comment' => 'L\'identifiant unique du CES de la CPAM'])]
    private ?RefCes $refCes = null;

    #[ORM\Column(type: 'string', length: 255, name: 'title', options: ['comment' => 'Le nom court du site CPAM'])]
    private ?string $title = null;

    public function getCpamId(): ?int
    {
        return $this->cpamId;
    }

    public function setCpamId(int $cpamId): self
    {
        $this->cpamId = $cpamId;
        return $this;
    }

    public function getRefCes(): ?RefCes
    {
        return $this->refCes;
    }

    public function setRefCes(?RefCes $refCes): self
    {
        $this->refCes = $refCes;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
