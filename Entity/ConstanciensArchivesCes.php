<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConstanciensArchivesCesRepository;

#[ORM\Entity(repositoryClass: ConstanciensArchivesCesRepository::class)]
#[ORM\Table(name: 'constanciens_archives_ces')]
class ConstanciensArchivesCes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'archive_id', options: ['comment' => 'ID unique de l\'archive'])]
    private ?int $archiveId = null;

    #[ORM\ManyToOne(targetEntity: Constanciens::class)]
    #[ORM\JoinColumn(nullable: false, name: 'constancien_id', referencedColumnName: 'constancien_id')]
    private ?Constanciens $constancien = null;

    #[ORM\Column(type: 'string', length: 255, name: 'ces', options: ['comment' => 'CES archivés'])]
    private ?string $ces = null;

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

    public function getCes(): ?string
    {
        return $this->ces;
    }

    public function setCes(string $ces): self
    {
        $this->ces = $ces;
        return $this;
    }
}
