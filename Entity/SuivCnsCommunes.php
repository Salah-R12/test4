<?php

namespace App\Entity;

use App\Repository\SuivCnsCommunesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuivCnsCommunesRepository::class)]
#[ORM\Table(name: 'suiv_cns_communes')]
class SuivCnsCommunes
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 5, name: 'com_cp', options: ['comment' => 'code postal de la commune'])]
    private ?string $comCp = null;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 5, name: 'com_insee', options: ['comment' => 'code commune INSEE'])]
    private ?string $comInsee = null;

    #[ORM\Column(type: 'string', length: 3, name: 'com_dpt', options: ['comment' => 'numéro du département'])]
    private ?string $comDpt = null;

    #[ORM\Column(type: 'string', length: 50, name: 'com_nom', options: ['comment' => 'nom de la commune'])]
    private ?string $comNom = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true, name: 'continent', options: ['comment' => 'continent (ne sert à rien et n\'est pas utilisée)'])]
    private ?string $continent = null;


    public function getComCp(): ?string
    {
        return $this->comCp;
    }

    public function setComCp(string $comCp): self
    {
        $this->comCp = $comCp;

        return $this;
    }

    public function getComInsee(): ?string
    {
        return $this->comInsee;
    }

    public function setComInsee(string $comInsee): self
    {
        $this->comInsee = $comInsee;

        return $this;
    }

    public function getComDpt(): ?string
    {
        return $this->comDpt;
    }

    public function setComDpt(string $comDpt): self
    {
        $this->comDpt = $comDpt;

        return $this;
    }

    public function getComNom(): ?string
    {
        return $this->comNom;
    }

    public function setComNom(string $comNom): self
    {
        $this->comNom = $comNom;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(?string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }
}
