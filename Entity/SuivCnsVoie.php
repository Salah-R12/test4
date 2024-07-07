<?php

namespace App\Entity;

use App\Repository\SuivCnsVoieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuivCnsVoieRepository::class)]
#[ORM\Table(name: 'suiv_cns_voie')]
class SuivCnsVoie
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 3, name: 'voi_code', options: ['comment' => 'Code de la voie'])]
    private ?string $voiCode = null;

    #[ORM\Column(type: 'string', length: 30, name: 'voi_name', options: ['comment' => 'Nom de la voie'])]
    private ?string $voiName = null;

    public function getVoiCode(): ?string
    {
        return $this->voiCode;
    }

    public function setVoiCode(string $voiCode): self
    {
        $this->voiCode = $voiCode;

        return $this;
    }

    public function getVoiName(): ?string
    {
        return $this->voiName;
    }

    public function setVoiName(string $voiName): self
    {
        $this->voiName = $voiName;

        return $this;
    }
}
