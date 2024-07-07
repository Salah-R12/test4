<?php

namespace App\Entity;

use App\Repository\SuivCnsAdresseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuivCnsAdresseRepository::class)]
#[ORM\Table(name: 'suiv_cns_adresse')]
class SuivCnsAdresse
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 8, name: 'NConstances')]
    private ?string $nConstances = null;

    #[ORM\Id]
    #[ORM\Column(type: 'datetime', name: 'NewAdresDtCreat')]
    private ?\DateTimeInterface $newAdresDtCreat = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true, name: 'NewAdresNum')]
    private ?string $newAdresNum = null;

    #[ORM\Column(type: 'string', length: 30, nullable: true, name: 'NewAdresTypeVoie')]
    private ?string $newAdresTypeVoie = null;

    #[ORM\Column(type: 'string', length: 38, nullable: true, name: 'NewAdresNomVoie')]
    private ?string $newAdresNomVoie = null;

    #[ORM\Column(type: 'string', length: 38, nullable: true, name: 'NewAdresCplt')]
    private ?string $newAdresCplt = null;

    #[ORM\Column(type: 'string', length: 5, name: 'newAdresCP')]
    private ?string $newAdresCP = null;

    #[ORM\Column(type: 'string', length: 38, name: 'NewAdresCommune')]
    private ?string $newAdresCommune = null;

    #[ORM\Column(type: 'string', length: 38, name: 'NewAdresPays')]
    private ?string $newAdresPays = null;

    #[ORM\Column(type: 'string', length: 38, nullable: true, name: 'NewAdresCplt2')]
    private ?string $newAdresCplt2 = null;

    #[ORM\Column(type: 'string', length: 38, name: 'NewAdresBD')]
    private ?string $newAdresBD = null;

    // Getters and setters...

    public function getNConstances(): ?string
    {
        return $this->nConstances;
    }

    public function setNConstances(string $nConstances): self
    {
        $this->nConstances = $nConstances;

        return $this;
    }

    public function getNewAdresDtCreat(): ?\DateTimeInterface
    {
        return $this->newAdresDtCreat;
    }

    public function setNewAdresDtCreat(\DateTimeInterface $newAdresDtCreat): self
    {
        $this->newAdresDtCreat = $newAdresDtCreat;

        return $this;
    }

    public function getNewAdresNum(): ?string
    {
        return $this->newAdresNum;
    }

    public function setNewAdresNum(?string $newAdresNum): self
    {
        $this->newAdresNum = $newAdresNum;

        return $this;
    }

    public function getNewAdresTypeVoie(): ?string
    {
        return $this->newAdresTypeVoie;
    }

    public function setNewAdresTypeVoie(?string $newAdresTypeVoie): self
    {
        $this->newAdresTypeVoie = $newAdresTypeVoie;

        return $this;
    }

    public function getNewAdresNomVoie(): ?string
    {
        return $this->newAdresNomVoie;
    }

    public function setNewAdresNomVoie(?string $newAdresNomVoie): self
    {
        $this->newAdresNomVoie = $newAdresNomVoie;

        return $this;
    }

    public function getNewAdresCplt(): ?string
    {
        return $this->newAdresCplt;
    }

    public function setNewAdresCplt(?string $newAdresCplt): self
    {
        $this->newAdresCplt = $newAdresCplt;

        return $this;
    }

    public function getNewAdresCP(): ?string
    {
        return $this->newAdresCP;
    }

    public function setNewAdresCP(string $newAdresCP): self
    {
        $this->newAdresCP = $newAdresCP;

        return $this;
    }

    public function getNewAdresCommune(): ?string
    {
        return $this->newAdresCommune;
    }

    public function setNewAdresCommune(string $newAdresCommune): self
    {
        $this->newAdresCommune = $newAdresCommune;

        return $this;
    }

    public function getNewAdresPays(): ?string
    {
        return $this->newAdresPays;
    }

    public function setNewAdresPays(string $newAdresPays): self
    {
        $this->newAdresPays = $newAdresPays;

        return $this;
    }

    public function getNewAdresCplt2(): ?string
    {
        return $this->newAdresCplt2;
    }

    public function setNewAdresCplt2(?string $newAdresCplt2): self
    {
        $this->newAdresCplt2 = $newAdresCplt2;

        return $this;
    }

    public function getNewAdresBD(): ?string
    {
        return $this->newAdresBD;
    }

    public function setNewAdresBD(string $newAdresBD): self
    {
        $this->newAdresBD = $newAdresBD;

        return $this;
    }
}
