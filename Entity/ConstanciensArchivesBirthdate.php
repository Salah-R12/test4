<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConstanciensArchivesBirthdateRepository;

#[ORM\Entity(repositoryClass: ConstanciensArchivesBirthdateRepository::class)]
#[ORM\Table(name: 'constanciens_archives_birthdate')]
class ConstanciensArchivesBirthdate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'archive_id', options: ['comment' => 'ID unique de l\'archive'])]
    private ?int $archiveId = null;

    #[ORM\ManyToOne(targetEntity: Constanciens::class)]
    #[ORM\JoinColumn(nullable: false, name: 'constancien_id', referencedColumnName: 'constancien_id')]
    private ?Constanciens $constancien = null;

    #[ORM\Column(type: 'date', name: 'birth_date', options: ['comment' => 'Date de naissance archivées'])]
    private ?\DateTimeInterface $birthDate = null;

    public function getArchiveId(): ?int
    {
        return $this->archiveId;
    }

    public function getConstancien(): ?Constanciens
    {
        return $this->constancien;
    }

    public function setConstancien(?Constanciens $constancien): self
    {
        $this->constancien = $constancien;
        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }
}
