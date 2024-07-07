<?php

namespace App\Entity;

use App\Repository\SuivRgpdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuivRgpdRepository::class)]
#[ORM\Table(name: 'suiv_RGPD')]
class SuivRgpd
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', name: 'constancien_id', length: 8, options: ['comment' => 'identifiant Constances'])]
    private ?int $constancienId = null;

    #[ORM\Column(type: 'datetime', nullable: true, name: 'date_suppr_constanciens', options: ['comment' => 'date de nettoyage dans la table constanciens'])]
    private ?\DateTimeInterface $dateSupprConstanciens = null;

    #[ORM\Column(type: 'datetime', nullable: true, name: 'date_suppr_suiv_cns_adresse', options: ['comment' => 'date de nettoyage dans la table suiv_cns_adresse'])]
    private ?\DateTimeInterface $dateSupprSuivCnsAdresse = null;

    // Getters and setters...

    public function getConstancienId(): ?int
    {
        return $this->constancienId;
    }

    public function setConstancienId(int $constancienId): self
    {
        $this->constancienId = $constancienId;

        return $this;
    }

    public function getDateSupprConstanciens(): ?\DateTimeInterface
    {
        return $this->dateSupprConstanciens;
    }

    public function setDateSupprConstanciens(?\DateTimeInterface $dateSupprConstanciens): self
    {
        $this->dateSupprConstanciens = $dateSupprConstanciens;

        return $this;
    }

    public function getDateSupprSuivCnsAdresse(): ?\DateTimeInterface
    {
        return $this->dateSupprSuivCnsAdresse;
    }

    public function setDateSupprSuivCnsAdresse(?\DateTimeInterface $dateSupprSuivCnsAdresse): self
    {
        $this->dateSupprSuivCnsAdresse = $dateSupprSuivCnsAdresse;

        return $this;
    }
}

