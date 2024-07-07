<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConstanciensArchivesEpsRepository;

#[ORM\Entity(repositoryClass: ConstanciensArchivesEpsRepository::class)]
#[ORM\Table(name: 'constanciens_archives_eps')]
class ConstanciensArchivesEps
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'archive_id', options: ['comment' => 'ID unique de l\'archive'])]
    private ?int $archiveId = null;

    #[ORM\ManyToOne(targetEntity: Constanciens::class)]
    #[ORM\JoinColumn(nullable: false, name: 'constancien_id', referencedColumnName: 'constancien_id')]
    private ?Constanciens $constancien = null;

    #[ORM\Column(type: 'string', length: 255, name: 'eps', options: ['comment' => 'EPS archivés'])]
    private ?string $eps = null;

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

    public function getEps(): ?string
    {
        return $this->eps;
    }

    public function setEps(string $eps): self
    {
        $this->eps = $eps;
        return $this;
    }
}
